<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {

            $table->id('id_pembayaran');

            $table->foreignId('id_tagihan')
                ->constrained('tagihans', 'id_tagihan')
                ->cascadeOnDelete();

            $table->decimal('nominal_pembayaran', 14, 2);

            $table->date('tanggal_bayar');

            $table->string('bukti_bayar');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};