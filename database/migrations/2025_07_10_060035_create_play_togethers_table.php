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
        Schema::create('play_togethers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('organizer_id');
            $table->string('organizer_type');
            $table->foreignId('sport_id')->constrained();
            $table->foreignId('venue_id')->nullable()->constrained();
            $table->date('scheduled_date');
            $table->dateTime('scheduled_time');
            $table->integer('max_participants');
            $table->integer('current_participants')->default(0);
            $table->string('skill_level')->nullable();
            $table->string('location')->nullable();
            $table->decimal('price_per_person', 10, 2)->default(0);
            $table->enum('status', ['open', 'closed', 'cancelled', 'completed'])->default('open');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index(['organizer_id', 'organizer_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('play_togethers');
    }
};
