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
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('sport_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('location');
            $table->string('city');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->decimal('price_per_hour', 10, 2);
            $table->json('images')->nullable();
            $table->json('facilities')->nullable();
            $table->time('open_time');
            $table->time('close_time');
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
