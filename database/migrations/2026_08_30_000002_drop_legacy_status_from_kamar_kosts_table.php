<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | HAPUS SUMBER STATUS KAMAR YANG LAMA
        |--------------------------------------------------------------------------
        |
        | Status kamar sekarang dihitung dari riwayat_hunians.status.
        | Kolom kamar_kosts.status dihapus agar tidak ada dua sumber kebenaran.
        |
        */
        if (Schema::hasColumn('kamar_kosts', 'status')) {
            Schema::table('kamar_kosts', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('kamar_kosts', 'status')) {
            Schema::table('kamar_kosts', function (Blueprint $table) {
                $table->enum('status', ['kosong', 'terisi'])
                    ->default('kosong');
            });
        }
    }
};
