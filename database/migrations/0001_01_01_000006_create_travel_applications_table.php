<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_applications', function (Blueprint $table) {
            $table->id();

            // Reference number — generated on create e.g. "TRV-2025-00042"
            $table->string('reference_number')->unique();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Travel type — drives the whole workflow
            // foreign_official: requires supervisor concurrence
            // foreign_private:  notification only
            // local:            notification only
            $table->string('travel_type');  // foreign_official | foreign_private | local
            // check constraint added below

            // Destination
            $table->foreignId('country_id')
                ->nullable()           // null for local travel
                ->constrained('countries')
                ->restrictOnDelete();
            $table->string('city')->nullable();
            $table->string('county')->nullable();    // for local travel
            $table->string('subcounty')->nullable(); // for local travel

            // Purpose (from FoTIMS)
            // conference | seminar | workshop | meeting | assignment
            // | formal_government | other
            $table->string('purpose_type')->nullable();
            $table->text('justification')->nullable();

            // Dates
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedSmallInteger('days_requested'); // computed: end - start + 1

            // Delegation & cost (foreign official)
            $table->unsignedTinyInteger('delegation_size')->default(1);
            $table->string('sponsor')->nullable();
            $table->decimal('total_cost_usd', 12, 2)->nullable();

            // Status — drives the UI and gate logic
            // draft | pending_concurrence | concurred | not_concurred
            // | returned | approved | travelling | pending_uploads | closed
            $table->string('status')->default('draft');

            // For local/private — auto-approved on submit, just logged
            $table->timestamp('auto_approved_at')->nullable();

            // Days docket snapshot at time of approval (audit)
            $table->unsignedSmallInteger('days_used_before')->nullable();
            $table->unsignedSmallInteger('days_used_after')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'travel_type']);
            $table->index('start_date');
        });

        DB::statement("
            ALTER TABLE travel_applications
            ADD CONSTRAINT chk_travel_type
            CHECK (travel_type IN ('foreign_official','foreign_private','local'))
        ");

        DB::statement("
            ALTER TABLE travel_applications
            ADD CONSTRAINT chk_application_status
            CHECK (status IN ('draft','pending_concurrence','concurred','not_concurred','returned','approved','travelling','pending_uploads','closed'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_applications');
    }
};
