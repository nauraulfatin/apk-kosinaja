<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * RUN MIGRATION
     */
    public function up(): void
    {
        Schema::create('riwayat_hunians', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_riwayat_hunian');

            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_user')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | KAMAR
            |--------------------------------------------------------------------------
            */

            $table->foreignId('id_kamar')
    ->nullable()
    ->constrained(
        'kamar_kosts',
        'id_kamar'
    )
    ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | TANGGAL HUNIAN
            |--------------------------------------------------------------------------
            */

            $table->date('tanggal_masuk');

            $table->date('tanggal_keluar')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | STATUS HUNIAN
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [

                'menunggu',

                'aktif',

                'nonaktif'

            ])->default('menunggu');

            /*
            |--------------------------------------------------------------------------
            | TIMESTAMPS
            |--------------------------------------------------------------------------
            */

            $table->timestamps();

        });
    }

    /**
     * ROLLBACK
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'riwayat_hunians'
        );
    }
};