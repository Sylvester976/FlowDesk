<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── application_logs ─────────────────────────────────
        Schema::table('application_logs', function (Blueprint $table) {
            $table->index('action',                'idx_app_logs_action');
            $table->index('user_id',               'idx_app_logs_user');
            $table->index('travel_application_id', 'idx_app_logs_app');
            $table->index('created_at',            'idx_app_logs_created');
        });

        // ── auth_logs ─────────────────────────────────────────
        Schema::table('auth_logs', function (Blueprint $table) {
            $table->index('event',      'idx_auth_logs_event');
            $table->index('user_id',    'idx_auth_logs_user');
            $table->index('ip_address', 'idx_auth_logs_ip');
            $table->index('created_at', 'idx_auth_logs_created');
        });

        // ── notifications ─────────────────────────────────────
        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['notifiable_id', 'read_at'], 'idx_notif_notifiable_read');
            $table->index('created_at',                 'idx_notif_created');
        });

        // ── travel_applications ───────────────────────────────
        Schema::table('travel_applications', function (Blueprint $table) {
            $table->index('status',       'idx_travel_status');
            $table->index('travel_type',  'idx_travel_type');
            $table->index('user_id',      'idx_travel_user');
            $table->index('departure_date','idx_travel_departure');
            $table->index('return_date',   'idx_travel_return');
        });

        // ── concurrence_steps ─────────────────────────────────
        Schema::table('concurrence_steps', function (Blueprint $table) {
            $table->index(['approver_id', 'action'], 'idx_concurrence_approver_action');
        });
    }

    public function down(): void
    {
        Schema::table('application_logs', function (Blueprint $table) {
            $table->dropIndex('idx_app_logs_action');
            $table->dropIndex('idx_app_logs_user');
            $table->dropIndex('idx_app_logs_app');
            $table->dropIndex('idx_app_logs_created');
        });

        Schema::table('auth_logs', function (Blueprint $table) {
            $table->dropIndex('idx_auth_logs_event');
            $table->dropIndex('idx_auth_logs_user');
            $table->dropIndex('idx_auth_logs_ip');
            $table->dropIndex('idx_auth_logs_created');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex('idx_notif_notifiable_read');
            $table->dropIndex('idx_notif_created');
        });

        Schema::table('travel_applications', function (Blueprint $table) {
            $table->dropIndex('idx_travel_status');
            $table->dropIndex('idx_travel_type');
            $table->dropIndex('idx_travel_user');
            $table->dropIndex('idx_travel_departure');
            $table->dropIndex('idx_travel_return');
        });

        Schema::table('concurrence_steps', function (Blueprint $table) {
            $table->dropIndex('idx_concurrence_approver_action');
        });
    }
};
