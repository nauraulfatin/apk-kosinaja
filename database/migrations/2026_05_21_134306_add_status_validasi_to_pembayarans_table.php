- <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {

            $table->enum(

                'status_validasi',

                [

                    'menunggu',
                    'diterima',
                    'ditolak'

                ]

            )
            ->default('menunggu');

        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {

            $table->dropColumn('status_validasi');

        });
    }
};