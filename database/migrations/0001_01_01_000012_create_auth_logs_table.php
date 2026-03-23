<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->id();

            // Nullable — failed logins may not map to a valid user
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('email_attempted')->nullable(); // raw email in case user not found

            // login_success | login_failed | otp_sent | otp_success
            // | otp_failed | otp_expired | lockout | logout
            $table->string('event');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('notes')->nullable();

            // Immutable
            $table->timestamp('created_at');

            $table->index(['user_id', 'created_at']);
            $table->index(['event', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auth_logs');
    }
};
