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
        Schema::create('community_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->integer('rank')->default(0);
            $table->integer('games_played')->default(0);
            $table->integer('games_won')->default(0);
            $table->integer('games_lost')->default(0);
            $table->decimal('win_percentage', 5, 2)->default(0.00);
            $table->integer('streak')->default(0); // positive for win streak, negative for loss streak
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();
            
            $table->unique(['community_id', 'user_id']);
            $table->index(['community_id', 'points']);
            $table->index(['community_id', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_rankings');
    }
};