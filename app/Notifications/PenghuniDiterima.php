<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PenghuniDiterima extends Notification
{
    use Queueable;

    public function __construct(
        public $riwayatHunian
    ) {}

    public function via($notifiable)
    {
        return [
            'database'
        ];
    }

    public function toDatabase($notifiable)
    {
        return [

            'jenis_notifikasi' =>
                'penghuni_diterima',

            'title' =>
                'Pengajuan Kos Diterima',

            'message' =>
                'Selamat, pengajuan masuk kos kamu telah diterima. Kamu sudah bisa mulai tinggal di kos.',

            'riwayat_hunian_id' =>
                $this->riwayatHunian->id_riwayat_hunian,

            'url' =>
                route('penghuni.dashboard'),

        ];
    }
}