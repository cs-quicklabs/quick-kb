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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->integer('status')->default(1)->comment('0- archived, 1- active, 2- draft');
            $table->text('slug')->unique();
            $table->integer('order')->default(0);
            $table->foreignId('module_id')
                  ->constrained('modules')
                  ->onDelete('cascade');
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('updated_by')
                ->nullable()
                ->default(null)
                ->constrained('users')
                ->onDelete('set null');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
