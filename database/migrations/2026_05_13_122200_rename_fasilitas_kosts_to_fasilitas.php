<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename(
            'fasilitas_kosts',
            'fasilitas'
        );
    }

    public function down(): void
    {
        Schema::rename(
            'fasilitas',
            'fasilitas_kosts'
        );
    }
};