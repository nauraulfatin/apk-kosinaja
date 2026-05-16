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
        Schema::create('aduan', function (Blueprint $table) {

            $table->id('id_aduan');

            $table->unsignedBigInteger('id_user');

            $table->text('isi_aduan');

            $table->string('foto_aduan')->nullable();

            $table->text('tanggapan_admin')->nullable();

            $table->enum('status', [
                'baru',
                'diproses',
                'selesai'
            ])->default('baru');

            $table->date('tanggal');

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan');
    }
};