<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('orders')
            ->where('status', 'menunggu verifikasi')
            ->update(['status' => Order::STATUS_PAID]);

        DB::table('orders')
            ->where('status', 'sukses')
            ->update(['status' => Order::STATUS_COMPLETED]);

        DB::table('orders')
            ->where('status', Order::STATUS_PAID)
            ->update(['payment_status' => Order::PAYMENT_STATUS_PAID]);
    }

    public function down(): void
    {
        // No-op: status normalization is intentionally one-way.
    }
};
