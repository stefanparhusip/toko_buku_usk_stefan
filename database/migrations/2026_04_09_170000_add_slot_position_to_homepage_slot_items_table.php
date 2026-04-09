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
        Schema::table('homepage_slot_items', function (Blueprint $table) {
            $table->unsignedInteger('slot_position')->nullable()->after('slot_id');
        });

        DB::statement(
            'UPDATE homepage_slot_items i '
            . 'INNER JOIN homepage_slots s ON s.id = i.slot_id '
            . 'SET i.slot_position = COALESCE(s.slot_number, s.position) '
            . 'WHERE i.slot_position IS NULL'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_slot_items', function (Blueprint $table) {
            $table->dropColumn('slot_position');
        });
    }
};
