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
        Schema::table('kosts', function (Blueprint $table) {

            $table->string('kode_undangan')
                ->unique()
                ->nullable()
                ->after('nama_kost');

        });
    }

    /**
     * ROLLBACK
     */
    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {

            $table->dropColumn(
                'kode_undangan'
            );

        });
    }
};