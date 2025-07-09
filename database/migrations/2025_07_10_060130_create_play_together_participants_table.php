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
        Schema::create('play_together_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('play_together_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('confirmed');
            $table->dateTime('joined_at');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['play_together_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('play_together_participants');
    }
};
