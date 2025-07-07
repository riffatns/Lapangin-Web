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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('sport_id')->constrained()->onDelete('cascade');
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->string('location');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->dateTime('registration_deadline');
            $table->integer('max_participants');
            $table->integer('current_participants')->default(0);
            $table->decimal('entry_fee', 8, 2)->nullable();
            $table->decimal('prize_pool', 8, 2)->nullable();
            $table->enum('format', ['single_elimination', 'double_elimination', 'round_robin', 'swiss'])->default('single_elimination');
            $table->enum('skill_level', ['all', 'beginner', 'intermediate', 'advanced', 'expert'])->default('all');
            $table->enum('status', ['upcoming', 'registration_open', 'registration_closed', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->json('rules')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};