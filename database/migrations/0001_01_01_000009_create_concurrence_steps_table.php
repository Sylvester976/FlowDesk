<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('concurrence_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->constrained('travel_applications')
                ->cascadeOnDelete();

            // null when is_system = true (PS auto-concur)
            $table->foreignId('approver_id')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            // concurred | not_concurred | returned | auto_concurred | pending
            $table->string('decision')->default('pending');
            $table->text('comments')->nullable();

            // Auto-concur flag for PS applications
            $table->boolean('is_system')->default(false);
            $table->string('system_reason')->nullable(); // "Applicant is PS — auto-concurred"

            $table->timestamp('decided_at')->nullable();
            $table->string('decided_ip')->nullable(); // audit: where decision was made from

            $table->timestamps();

            $table->index(['application_id', 'decision']);
        });

        DB::statement("
            ALTER TABLE concurrence_steps
            ADD CONSTRAINT chk_concurrence_decision
            CHECK (decision IN ('concurred','not_concurred','returned','auto_concurred','pending'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('concurrence_steps');
    }
};
