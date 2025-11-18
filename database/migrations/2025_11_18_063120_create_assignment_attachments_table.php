<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('my_assignments', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table (Livewire user model or default User)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Required fields
            $table->string('country_of_visit');

            // Optional fields
            $table->string('county')->nullable();
            $table->string('subcounty')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();

            // Supervisor details
            $table->string('supervisor_name');
            $table->string('supervisor_email')->nullable();

            // Assignment duration
            $table->date('start_date');
            $table->date('end_date');

            // timestamps
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_attachments');
    }
};
