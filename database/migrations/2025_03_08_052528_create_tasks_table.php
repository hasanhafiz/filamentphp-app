<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'canceled'])->default('pending');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('amount')->default(100);
            $table->foreignId('category_id');
            $table->dateTime('completion_date')->default(now()->addDays(3));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
