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
        // Add columns to play_togethers table for enhanced features
        Schema::table('play_togethers', function (Blueprint $table) {
            // Payment splitting features
            $table->boolean('is_paid_event')->default(false)->after('price_per_person');
            $table->decimal('total_cost', 10, 2)->default(0)->after('is_paid_event');
            $table->enum('payment_method', ['split_equal', 'organizer_pays', 'individual'])->default('split_equal')->after('total_cost');
            $table->boolean('payment_required_upfront')->default(false)->after('payment_method');
            
            // Enhanced venue integration
            $table->boolean('venue_partner')->default(false)->after('venue_id');
            $table->text('venue_notes')->nullable()->after('venue_partner');
            
            // Chat and communication
            $table->boolean('chat_enabled')->default(true)->after('venue_notes');
            $table->json('communication_settings')->nullable()->after('chat_enabled');
            
            // Advanced scheduling
            $table->integer('duration_minutes')->default(120)->after('scheduled_time');
            $table->datetime('registration_deadline')->nullable()->after('duration_minutes');
            
            // Skill level enhancements
            $table->json('skill_requirements')->nullable()->after('skill_level');
            $table->boolean('auto_approve')->default(true)->after('skill_requirements');
            
            // Additional metadata
            $table->json('additional_info')->nullable()->after('auto_approve');
            $table->text('rules_and_terms')->nullable()->after('additional_info');
        });

        // Create play_together_payments table for payment splitting
        Schema::create('play_together_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('play_together_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_due', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('payment_reference')->nullable();
            $table->datetime('paid_at')->nullable();
            $table->datetime('due_date')->nullable();
            $table->timestamps();

            $table->unique(['play_together_id', 'user_id']);
        });

        // Create play_together_chats table for messaging
        Schema::create('play_together_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('play_together_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->enum('message_type', ['text', 'image', 'file', 'system'])->default('text');
            $table->json('attachments')->nullable();
            $table->boolean('is_system_message')->default(false);
            $table->datetime('read_at')->nullable();
            $table->timestamps();

            $table->index(['play_together_id', 'created_at']);
        });

        // Create user_skill_profiles table for skill level system
        Schema::create('user_skill_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sport_id')->constrained()->onDelete('cascade');
            $table->enum('skill_level', ['beginner', 'intermediate', 'advanced', 'expert'])->default('beginner');
            $table->integer('experience_years')->default(0);
            $table->json('achievements')->nullable(); // Tournament wins, certificates, etc.
            $table->json('video_portfolio')->nullable(); // Video links for skill verification
            $table->text('bio')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_matches')->default(0);
            $table->boolean('verified')->default(false);
            $table->datetime('verified_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'sport_id']);
        });

        // Create skill_verifications table for portfolio review
        Schema::create('skill_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_skill_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->enum('verification_type', ['video', 'achievement', 'peer_review', 'admin_review']);
            $table->json('verification_data'); // Video URL, achievement details, etc.
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('reviewer_notes')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->datetime('reviewed_at')->nullable();
            $table->timestamps();
        });

        // Enhance play_together_participants table
        Schema::table('play_together_participants', function (Blueprint $table) {
            $table->enum('approval_status', ['auto_approved', 'pending', 'approved', 'rejected'])->default('auto_approved')->after('status');
            $table->text('join_message')->nullable()->after('approval_status');
            $table->decimal('skill_match_score', 3, 2)->nullable()->after('join_message');
            $table->datetime('payment_due_date')->nullable()->after('skill_match_score');
            $table->boolean('payment_completed')->default(false)->after('payment_due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('play_together_participants', function (Blueprint $table) {
            $table->dropColumn([
                'approval_status', 'join_message', 'skill_match_score', 
                'payment_due_date', 'payment_completed'
            ]);
        });

        Schema::dropIfExists('skill_verifications');
        Schema::dropIfExists('user_skill_profiles');
        Schema::dropIfExists('play_together_chats');
        Schema::dropIfExists('play_together_payments');

        Schema::table('play_togethers', function (Blueprint $table) {
            $table->dropColumn([
                'is_paid_event', 'total_cost', 'payment_method', 'payment_required_upfront',
                'venue_partner', 'venue_notes', 'chat_enabled', 'communication_settings',
                'duration_minutes', 'registration_deadline', 'skill_requirements', 
                'auto_approve', 'additional_info', 'rules_and_terms'
            ]);
        });
    }
};
