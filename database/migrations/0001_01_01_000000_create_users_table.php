<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('password');
            $table->string('no_hp')->nullable();
            $table->enum('role', ['super admin', 'admin kost', 'penghuni kost']);
            $table->enum('status', ['pending', 'aktif', 'ditolak'])->default('aktif');
            $table->boolean('must_change_password')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};
