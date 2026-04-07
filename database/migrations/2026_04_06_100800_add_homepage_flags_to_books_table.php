<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('image');
            $table->boolean('is_recommended')->default(false)->after('is_featured');
            $table->boolean('is_new')->default(false)->after('is_recommended');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'is_recommended', 'is_new']);
        });
    }
};
