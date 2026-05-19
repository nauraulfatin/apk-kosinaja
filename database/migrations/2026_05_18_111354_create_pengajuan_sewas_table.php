<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_sewas', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | PRIMARY KEY
            |--------------------------------------------------------------------------
            */

            $table->id('id_pengajuan');

            /*
            |--------------------------------------------------------------------------
            | USER
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('id_user');

            /*
            |--------------------------------------------------------------------------
            | KAMAR
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('id_kamar');

            /*
            |--------------------------------------------------------------------------
            | HARGA KAMAR
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('id_harga_kamar');

            /*
            |--------------------------------------------------------------------------
            | TANGGAL BOOKING
            |--------------------------------------------------------------------------
            */

            $table->date('tanggal_masuk');

            $table->date('tanggal_keluar');

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [

                'menunggu',

                'diterima',

                'ditolak'

            ])->default('menunggu');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY USER
            |--------------------------------------------------------------------------
            */

            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY KAMAR
            |--------------------------------------------------------------------------
            */

            $table->foreign('id_kamar')
                  ->references('id_kamar')
                  ->on('kamar_kosts')
                  ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY HARGA KAMAR
            |--------------------------------------------------------------------------
            */

            $table->foreign('id_harga_kamar')
                  ->references('id_harga_kamar')
                  ->on('harga_kamars')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sewas');
    }
};