<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aduan', function (Blueprint $table) {

            $table->unsignedBigInteger('kost_id')->nullable()->after('id_user');

        });
    }

    public function down(): void
    {
        Schema::table('aduan', function (Blueprint $table) {

            $table->dropColumn('kost_id');

        });
    }
};