<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nama_penerima')->default('Penerima')->after('order_code');
            $table->string('phone', 30)->default('-')->after('nama_penerima');
            $table->string('address', 1000)->default('-')->after('phone');
            $table->string('city')->default('-')->after('address');
            $table->string('postal_code', 20)->default('-')->after('city');
            $table->integer('total_price')->default(0)->after('postal_code');
        });

        DB::table('orders')->update([
            'total_price' => DB::raw('COALESCE(total_price, total_payment)'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nama_penerima',
                'phone',
                'address',
                'city',
                'postal_code',
                'total_price',
            ]);
        });
    }
};
