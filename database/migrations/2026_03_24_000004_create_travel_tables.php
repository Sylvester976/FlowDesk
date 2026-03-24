<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop and recreate cleanly if exists from prototype
        Schema::dropIfExists('application_documents');
        Schema::dropIfExists('concurrence_steps');
        Schema::dropIfExists('supervisor_feedback');
        Schema::dropIfExists('post_trip_uploads');
        Schema::dropIfExists('application_logs');
        Schema::dropIfExists('travel_applications');

        Schema::create('travel_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Type
            $table->enum('travel_type', ['foreign_official', 'foreign_private', 'local']);

            // Destination
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->foreignId('county_id')->nullable()->constrained('counties')->nullOnDelete();
            $table->string('destination_details')->nullable(); // city/specific location

            // Trip details
            $table->date('departure_date');
            $table->date('return_date');
            $table->integer('per_diem_days')->nullable();
            $table->string('funding_source')->nullable();
            $table->text('purpose'); // mandatory description

            // Leave (foreign private)
            $table->boolean('leave_approved')->nullable();

            // Status
            $table->enum('status', [
                'draft',
                'submitted',
                'pending_concurrence',
                'concurred',
                'not_concurred',
                'returned',
                'cancelled',
                'pending_uploads',
                'closed',
            ])->default('draft');

            // Reference number (auto-generated on submit)
            $table->string('reference_number')->nullable()->unique();

            // Clearance letter
            $table->string('clearance_letter_path')->nullable();
            $table->timestamp('clearance_letter_generated_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // Check constraints
        DB::statement("ALTER TABLE travel_applications ADD CONSTRAINT chk_dates
            CHECK (return_date >= departure_date)");

        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_application_id')
                ->constrained('travel_applications')->cascadeOnDelete();
            $table->enum('document_type', [
                'invitation_letter',
                'appointment_letter',
                'passport_copy',
                'leave_form',
                'post_trip_report',
                'post_trip_ticket',
                'post_trip_passport',
                'other',
            ]);
            $table->string('file_path');
            $table->string('original_name');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
        });

        Schema::create('concurrence_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_application_id')
                ->constrained('travel_applications')->cascadeOnDelete();
            $table->foreignId('approver_id')->constrained('users');
            $table->enum('action', ['pending', 'concurred', 'not_concurred', 'returned']);
            $table->text('comments')->nullable();
            $table->timestamp('acted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('application_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_application_id')
                ->constrained('travel_applications')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->string('action');
            $table->text('description')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('post_trip_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_application_id')
                ->constrained('travel_applications')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->text('report_summary')->nullable();
            $table->decimal('actual_cost', 12, 2)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_trip_uploads');
        Schema::dropIfExists('application_logs');
        Schema::dropIfExists('concurrence_steps');
        Schema::dropIfExists('application_documents');
        Schema::dropIfExists('travel_applications');
    }
};
