<?php

namespace App\Services;

use App\Models\Kost;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KostDeletionService
{
    /**
     * Hapus satu kos beserta seluruh data yang memang dimiliki kos tersebut.
     *
     * Akun penghuni TIDAK dihapus. Yang dihapus adalah relasi/riwayat hunian,
     * tagihan, pembayaran, aduan, aturan, kamar, harga, dan pivot fasilitas.
     */
    public function delete(Kost $kost): void
    {
        $mediaPaths = [];

        DB::transaction(function () use ($kost, &$mediaPaths) {
            $kost->load([
                'kamars:id_kamar,id_kost,foto_kamar',
                'aduans:id_aduan,kost_id,foto_aduan',
            ]);

            foreach ($kost->foto_kost ?? [] as $path) {
                if ($path) {
                    $mediaPaths[] = $path;
                }
            }

            foreach ($kost->kamars as $kamar) {
                foreach ($kamar->foto_kamar ?? [] as $path) {
                    if ($path) {
                        $mediaPaths[] = $path;
                    }
                }
            }

            foreach ($kost->aduans as $aduan) {
                if ($aduan->foto_aduan) {
                    $mediaPaths[] = $aduan->foto_aduan;
                }
            }

            $kamarIds = $kost->kamars->pluck('id_kamar');

            if ($kamarIds->isNotEmpty()) {
                $tagihans = Tagihan::whereIn('id_kamar', $kamarIds)
                    ->get(['id_tagihan', 'bukti_bayar']);

                foreach ($tagihans as $tagihan) {
                    if ($tagihan->bukti_bayar) {
                        $mediaPaths[] = $tagihan->bukti_bayar;
                    }
                }

                $tagihanIds = $tagihans->pluck('id_tagihan');

                if ($tagihanIds->isNotEmpty()) {
                    $pembayaranPaths = Pembayaran::whereIn('id_tagihan', $tagihanIds)
                        ->whereNotNull('bukti_bayar')
                        ->pluck('bukti_bayar');

                    foreach ($pembayaranPaths as $path) {
                        if ($path) {
                            $mediaPaths[] = $path;
                        }
                    }

                    // Tagihan dihapus lebih dulu supaya FK harga_kamar yang RESTRICT
                    // tidak menghambat proses penghapusan kamar/kos.
                    Tagihan::whereIn('id_tagihan', $tagihanIds)->delete();
                }
            }

            // FK database menangani cascade untuk:
            // kamar -> harga/fasilitas_kamar
            // kost -> fasilitas_kost/peraturan/aduan/riwayat_hunian
            $kost->delete();
        });

        $mediaPaths = array_values(array_unique(array_filter($mediaPaths)));

        if ($mediaPaths !== []) {
            try {
                Storage::disk('public')->delete($mediaPaths);
            } catch (\Throwable $e) {
                // Data utama sudah aman terhapus di DB. Kegagalan cleanup file dicatat.
                Log::warning('Gagal menghapus sebagian media kos setelah data DB dihapus.', [
                    'paths' => $mediaPaths,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
