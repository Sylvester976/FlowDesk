<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supervisor_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->constrained('travel_applications')
                ->cascadeOnDelete();
            $table->foreignId('supervisor_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Advisory only — cannot block travel
            // agrees | disagrees | no_objection
            $table->string('stance');
            $table->text('comments')->nullable();

            // Immutable once submitted — no updated_at intentionally used
            // but timestamps() still records created_at
            $table->timestamps();

            $table->unique(['application_id', 'supervisor_id']);
        });

        DB::statement("
            ALTER TABLE supervisor_feedback
            ADD CONSTRAINT chk_feedback_stance
            CHECK (stance IN ('agrees','disagrees','no_objection'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('supervisor_feedback');
    }
};
