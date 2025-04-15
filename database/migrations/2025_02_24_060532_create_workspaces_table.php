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
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('slug');
            $table->integer('order')->default(0);
            $table->integer('status')->default(1)->comment('1 - active, 0 - archived');
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
        Schema::dropIfExists('workspaces');
    }
};
