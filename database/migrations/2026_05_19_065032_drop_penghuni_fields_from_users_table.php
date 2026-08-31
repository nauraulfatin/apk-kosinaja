<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columnsToDrop = [];

        foreach (['id_kost', 'id_kamar', 'status_penghuni'] as $column) {
            if (Schema::hasColumn('users', $column)) {
                $columnsToDrop[] = $column;
            }
        }

        if ($columnsToDrop !== []) {
            Schema::table('users', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_kost')) {
                $table->unsignedBigInteger('id_kost')->nullable();
            }

            if (!Schema::hasColumn('users', 'id_kamar')) {
                $table->unsignedBigInteger('id_kamar')->nullable();
            }

            if (!Schema::hasColumn('users', 'status_penghuni')) {
                $table->enum('status_penghuni', ['calon', 'aktif', 'nonaktif'])->nullable();
            }
        });
    }
};
