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
        Schema::table('books', function (Blueprint $table) {
            $table->string('image_url', 2048)->nullable()->after('image');
        });

        DB::statement('ALTER TABLE books MODIFY image VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE books SET image = '' WHERE image IS NULL");
        DB::statement('ALTER TABLE books MODIFY image VARCHAR(255) NOT NULL');

        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
