<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->constrained('travel_applications')
                ->cascadeOnDelete();

            // Who triggered the action — null for system actions
            $table->foreignId('actor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('actor_label')->nullable(); // snapshot name in case user deleted

            // What happened
            // submitted | status_changed | document_uploaded | document_deleted
            // | feedback_given | concurrence_decision | post_trip_submitted
            // | auto_concurred | days_docket_updated | application_cancelled
            $table->string('event');

            // Status transition snapshot
            $table->string('from_status')->nullable();
            $table->string('to_status')->nullable();

            // Free-form detail — JSON so anything can be stored
            // e.g. {"decision": "concurred", "days_before": 5, "days_after": 12}
            $table->jsonb('payload')->nullable();

            // Immutable — no updated_at
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at');

            $table->index(['application_id', 'created_at']);
            $table->index('event');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_logs');
    }
};
