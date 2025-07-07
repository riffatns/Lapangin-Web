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
        Schema::create('play_together', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('sport_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            $table->dateTime('scheduled_time');
            $table->integer('max_participants');
            $table->integer('current_participants')->default(1);
            $table->decimal('price_per_person', 8, 2)->nullable();
            $table->enum('skill_level', ['all', 'beginner', 'intermediate', 'advanced', 'expert'])->default('all');
            $table->enum('status', ['open', 'full', 'cancelled', 'completed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('play_together');
    }
};