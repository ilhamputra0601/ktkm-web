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
        Schema::create('reels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id')->cascadeOnDelete();
            // $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            // $table->string('thumbnail')->nullable();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('images');
            $table->text('content')->nullable();
            // $table->text('body')->nullable();
            // $table->json('tags')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reels');
    }
};
