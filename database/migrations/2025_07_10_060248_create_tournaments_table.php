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
        // Drop existing table if it exists to create new structure
        Schema::dropIfExists('tournaments');
        
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('organizer_id');
            $table->string('organizer_type');
            $table->foreignId('sport_id')->constrained();
            $table->foreignId('venue_id')->nullable()->constrained();
            $table->string('tournament_type')->default('single_elimination');
            $table->integer('max_participants');
            $table->integer('current_participants')->default(0);
            $table->dateTime('registration_start');
            $table->dateTime('registration_end');
            $table->dateTime('tournament_start');
            $table->dateTime('tournament_end');
            $table->decimal('entry_fee', 10, 2)->default(0);
            $table->decimal('prize_pool', 10, 2)->default(0);
            $table->string('skill_level')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['upcoming', 'registration_open', 'registration_closed', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_public')->default(true);
            $table->text('rules')->nullable();
            $table->timestamps();

            $table->index(['organizer_id', 'organizer_type']);
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
