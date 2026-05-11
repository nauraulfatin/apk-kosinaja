<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('fasilitas_kosts', function(Blueprint $table){ $table->id('id_fasilitas'); $table->string('nama_fasilitas')->unique(); $table->timestamps(); }); } public function down(): void { Schema::dropIfExists('fasilitas_kosts'); } };
