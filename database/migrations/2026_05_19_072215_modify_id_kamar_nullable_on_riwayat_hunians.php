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
        Schema::table('riwayat_hunians', function (Blueprint $table) {

            $table->foreignId('id_kamar')
                ->nullable()
                ->change();

        });
    }

    /**
     * ROLLBACK
     */
    public function down(): void
    {
        Schema::table('riwayat_hunians', function (Blueprint $table) {

            $table->foreignId('id_kamar')
                ->nullable(false)
                ->change();

        });
    }
};