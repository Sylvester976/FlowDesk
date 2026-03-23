<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Identity
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_names')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');

            // Work identity
            $table->string('pf_number')->unique()->nullable();     // payroll number
            $table->string('id_number')->unique()->nullable();
            $table->string('passport_number')->nullable();
            $table->string('diplomatic_passport_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_appointment')->nullable();

            // Org placement
            $table->foreignId('role_id')
                ->constrained('roles')
                ->restrictOnDelete();
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            // supervisor_id: self-referencing, added via separate migration
            // after the users table exists

            // Travel docket
            $table->unsignedSmallInteger('max_days_per_year')->default(30);
            $table->unsignedSmallInteger('days_used_this_year')->default(0);
            $table->unsignedSmallInteger('docket_year')->default(0); // tracks which year days_used is for

            // Account status
            $table->string('status')->default('pending'); // pending, active, inactive
            $table->string('profile_photo')->nullable();

            // Auth
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        // Self-referencing supervisor relationship — added after table exists
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('supervisor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });

        // Head of directorate/department FKs — now users table exists
        Schema::table('directorates', function (Blueprint $table) {
            $table->foreign('head_user_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('head_user_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['head_user_id']);
        });
        Schema::table('directorates', function (Blueprint $table) {
            $table->dropForeign(['head_user_id']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropColumn('supervisor_id');
        });
        Schema::dropIfExists('users');
    }
};
