<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | KOST AKTIF
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('id_kost')
                  ->nullable()
                  ->after('status');

            /*
            |--------------------------------------------------------------------------
            | KAMAR AKTIF
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('id_kamar')
                  ->nullable()
                  ->after('id_kost');

            /*
            |--------------------------------------------------------------------------
            | STATUS PENGHUNI
            |--------------------------------------------------------------------------
            */

            $table->enum('status_penghuni', [

                'calon',

                'aktif',

                'nonaktif'

            ])
            ->nullable()
            ->after('id_kamar');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([

                'id_kost',

                'id_kamar',

                'status_penghuni'

            ]);

        });
    }
};