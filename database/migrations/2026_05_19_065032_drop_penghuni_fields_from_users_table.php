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
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | DROP KOLOM LAMA
            |--------------------------------------------------------------------------
            */

            $table->dropColumn([

                'id_kost',

                'id_kamar',

                'status_penghuni'

            ]);

        });
    }

    /**
     * ROLLBACK
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | KEMBALIKAN KOLOM
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('id_kost')
                ->nullable();

            $table->unsignedBigInteger('id_kamar')
                ->nullable();

            $table->enum('status_penghuni', [

                'calon',

                'aktif',

                'nonaktif'

            ])->nullable();

        });
    }
};