<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kosts', function (Blueprint $table) {

            $table->json('foto_kost')
                  ->nullable()
                  ->change();

        });
    }

    public function down(): void
    {
        Schema::table('kosts', function (Blueprint $table) {

            $table->string('foto_kost')
                  ->nullable()
                  ->change();

        });
    }
};