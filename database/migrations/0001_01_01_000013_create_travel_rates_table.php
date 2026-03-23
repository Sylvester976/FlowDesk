<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')
                ->nullable()           // null = local/domestic rate
                ->constrained('countries')
                ->cascadeOnDelete();
            $table->foreignId('role_id')
                ->nullable()           // null = applies to all roles
                ->constrained('roles')
                ->cascadeOnDelete();

            $table->decimal('daily_subsistence_usd', 10, 2);  // DSA rate
            $table->decimal('accommodation_usd', 10, 2)->nullable();
            $table->string('currency_code', 3)->default('USD');

            // Effective period — allows rate history
            $table->date('effective_from');
            $table->date('effective_to')->nullable(); // null = currently active

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['country_id', 'effective_from']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('travel_rates');
    }
};
