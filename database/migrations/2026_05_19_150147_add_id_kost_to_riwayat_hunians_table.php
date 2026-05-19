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
        Schema::table('riwayat_hunians', function (Blueprint $table) {

            $table->unsignedInteger('id_kost')
                ->nullable()
                ->after('id_user');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_hunians', function (Blueprint $table) {

            $table->dropColumn('id_kost');

        });
    }
};