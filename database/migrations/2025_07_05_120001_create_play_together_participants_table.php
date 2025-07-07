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
            $table->foreignId('play_together_id')->constrained('play_together')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['joined', 'pending', 'cancelled'])->default('joined');
            $table->timestamp('joined_at')->useCurrent();
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