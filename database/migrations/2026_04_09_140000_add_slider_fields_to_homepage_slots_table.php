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
        Schema::table('homepage_slots', function (Blueprint $table) {
            $table->unsignedInteger('slot_number')->nullable()->after('position');
            $table->string('button_text')->nullable()->after('image_url');
            $table->unsignedInteger('order_number')->default(1)->after('button_text');
        });

        DB::statement('UPDATE homepage_slots SET slot_number = position WHERE slot_number IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_slots', function (Blueprint $table) {
            $table->dropColumn(['slot_number', 'button_text', 'order_number']);
        });
    }
};
