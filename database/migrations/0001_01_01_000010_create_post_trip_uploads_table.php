<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_trip_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->unique()                // one post-trip record per application
                ->constrained('travel_applications')
                ->cascadeOnDelete();
            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->restrictOnDelete();

            // Required files (paths)
            $table->string('ticket_path')->nullable();         // actual ticket scan
            $table->string('passport_path')->nullable();       // passport stamps
            $table->string('report_path')->nullable();         // detailed trip report

            // Cost actuals (for reconciliation vs estimated)
            $table->decimal('accommodation_cost', 12, 2)->nullable();
            $table->decimal('ticket_cost', 12, 2)->nullable();
            $table->decimal('participation_fee', 12, 2)->nullable();

            // Trip outcomes
            $table->text('achievements')->nullable(); // what was achieved/learned

            // Submitted timestamp — marks assignment as closed
            $table->timestamp('submitted_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_trip_uploads');
    }
};
