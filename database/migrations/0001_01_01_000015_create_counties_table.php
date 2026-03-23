<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('code');      // official county code 001-047
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Add county_id to travel_applications for local travel
        Schema::table('travel_applications', function (Blueprint $table) {
            $table->foreignId('county_id')
                ->nullable()
                ->after('city')
                ->constrained('counties')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('travel_applications', function (Blueprint $table) {
            $table->dropForeign(['county_id']);
            $table->dropColumn('county_id');
        });
        Schema::dropIfExists('counties');
    }
};
