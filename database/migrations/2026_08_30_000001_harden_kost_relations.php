<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Peraturan wajib terikat ke kos dan ikut terhapus saat kos dihapus.
        Schema::table('peraturans', function (Blueprint $table) {
            $table->foreign('kost_id')
                ->references('id')
                ->on('kosts')
                ->cascadeOnDelete();
        });

        // Aduan boleh legacy/null, tetapi jika terikat ke kos harus ikut terhapus.
        Schema::table('aduan', function (Blueprint $table) {
            $table->foreign('kost_id')
                ->references('id')
                ->on('kosts')
                ->cascadeOnDelete();
        });

        // Samakan tipe FK dengan kosts.id (BIGINT UNSIGNED), lalu pasang cascade.
        Schema::table('riwayat_hunians', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kost')->nullable()->change();
        });

        Schema::table('riwayat_hunians', function (Blueprint $table) {
            $table->foreign('id_kost')
                ->references('id')
                ->on('kosts')
                ->cascadeOnDelete();
        });

        // created_by adalah referensi user. Jika pembuat akun dihapus, akun yang dibuat tetap ada.
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });

        Schema::table('riwayat_hunians', function (Blueprint $table) {
            $table->dropForeign(['id_kost']);
        });

        Schema::table('riwayat_hunians', function (Blueprint $table) {
            $table->unsignedInteger('id_kost')->nullable()->change();
        });

        Schema::table('aduan', function (Blueprint $table) {
            $table->dropForeign(['kost_id']);
        });

        Schema::table('peraturans', function (Blueprint $table) {
            $table->dropForeign(['kost_id']);
        });
    }
};
