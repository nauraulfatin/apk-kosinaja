<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periode_penagihans', function (Blueprint $table) {
            $table->id('id_penagihan');
            $table->string('periode_penagihan')->unique();
            $table->unsignedInteger('jumlah_interval')->default(1);
            $table->enum('satuan_interval', ['hari', 'minggu', 'bulan', 'tahun'])->default('bulan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periode_penagihans');
    }
};
