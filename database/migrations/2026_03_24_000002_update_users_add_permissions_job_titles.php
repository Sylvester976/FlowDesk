<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Job titles table ──────────────────────────────────────
        Schema::create('job_titles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnDelete();
            $table->string('name');           // e.g. "ICT Officer I", "HRM Officer"
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['role_id', 'name']);
        });

        // ── Add new columns to users ───────────────────────────────
        Schema::table('users', function (Blueprint $table) {
            // Permissions — independent of hierarchy role
            $table->boolean('is_superadmin')->default(false)->after('status');
            $table->boolean('is_hr_admin')->default(false)->after('is_superadmin');

            // Job title (optional, filtered by role)
            $table->foreignId('job_title_id')
                ->nullable()
                ->after('role_id')
                ->constrained('job_titles')
                ->nullOnDelete();

            // Matrix reporting — seconded/attached to another office
            $table->foreignId('attached_to_id')
                ->nullable()
                ->after('supervisor_id')
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['attached_to_id']);
            $table->dropForeign(['job_title_id']);
            $table->dropColumn(['is_superadmin', 'is_hr_admin', 'job_title_id', 'attached_to_id']);
        });

        Schema::dropIfExists('job_titles');
    }
};
