<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('user_service_id')->nullable()->unique()->after('id');
            $table->enum('sync_status', ['unlinked', 'pending', 'synced', 'conflict'])
                ->default('unlinked')->after('user_service_id');
            $table->string('sync_direction', 20)
                ->default('local_only')
                ->comment('local_only | linked')
                ->after('sync_status');
            $table->timestamp('last_synced_at')->nullable()->after('sync_direction');
            $table->json('sync_meta')->nullable()
                ->comment('last conflict details, error messages etc')
                ->after('last_synced_at');
        });

        // Index for fast sync lookups
        Schema::table('users', function (Blueprint $table) {
            $table->index('sync_status',      'idx_users_sync_status');
            $table->index('last_synced_at',   'idx_users_last_synced');
            $table->index('user_service_id',  'idx_users_service_id');
        });

        // Sync log table
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('sync_type', ['full', 'delta', 'single', 'manual', 'webhook', 'startup'])
                ->default('manual');
            $table->enum('direction', ['push', 'pull', 'reconcile'])->default('reconcile');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('total_records')->default(0);
            $table->integer('synced_count')->default(0);
            $table->integer('skipped_count')->default(0);
            $table->integer('conflict_count')->default(0);
            $table->integer('error_count')->default(0);
            $table->json('conflicts')->nullable();
            $table->json('errors')->nullable();
            $table->foreignId('triggered_by')->nullable()
                ->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_sync_status');
            $table->dropIndex('idx_users_last_synced');
            $table->dropIndex('idx_users_service_id');
            $table->dropColumn([
                'user_service_id', 'sync_status',
                'sync_direction', 'last_synced_at', 'sync_meta',
            ]);
        });

        Schema::dropIfExists('sync_logs');
    }
};
