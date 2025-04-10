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
        Schema::create('article_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
                  ->constrained('articles')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->nullable()
                  ->default(null)
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->integer('rating')->comment('1- 1 star, 2- 2 stars, 3- 3 stars, 4- 4 stars, 5- 5 stars');
            $table->text('comment')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_ratings');
    }
};
