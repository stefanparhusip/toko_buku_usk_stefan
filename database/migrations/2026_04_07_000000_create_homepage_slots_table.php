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
        Schema::create('homepage_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('book_id')->nullable()->constrained('books')->nullOnDelete();
            $table->string('link')->nullable();
            $table->enum('type', ['hero', 'banner', 'book']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_slots');
    }
};
