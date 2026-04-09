<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasPaymentStatus = Schema::hasColumn('orders', 'payment_status');
        $hasReceiptNumber = Schema::hasColumn('orders', 'receipt_number');

        Schema::table('orders', function (Blueprint $table) use ($hasPaymentStatus, $hasReceiptNumber) {
            if (! $hasPaymentStatus) {
                $table->string('payment_status')->default(Order::PAYMENT_STATUS_PENDING)->after('payment_method');
            }

            if (! $hasReceiptNumber) {
                $table->string('receipt_number')->nullable()->after('payment_status');
                $table->unique('receipt_number');
            }
        });

        DB::table('orders')
            ->where('payment_method', Order::PAYMENT_BANK_TRANSFER_LEGACY)
            ->update(['payment_method' => Order::PAYMENT_BANK_TRANSFER]);

        DB::table('orders')
            ->whereNull('payment_status')
            ->update(['payment_status' => Order::PAYMENT_STATUS_PENDING]);
    }

    public function down(): void
    {
        $hasPaymentStatus = Schema::hasColumn('orders', 'payment_status');
        $hasReceiptNumber = Schema::hasColumn('orders', 'receipt_number');

        Schema::table('orders', function (Blueprint $table) use ($hasPaymentStatus, $hasReceiptNumber) {
            if ($hasReceiptNumber) {
                $table->dropUnique('orders_receipt_number_unique');
                $table->dropColumn('receipt_number');
            }

            if ($hasPaymentStatus) {
                $table->dropColumn('payment_status');
            }
        });

        DB::table('orders')
            ->where('payment_method', Order::PAYMENT_BANK_TRANSFER)
            ->update(['payment_method' => Order::PAYMENT_BANK_TRANSFER_LEGACY]);
    }
};
