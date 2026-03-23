<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();          // slug: superadmin, ps, hr, director, officer
            $table->string('label');                   // display: "Principal Secretary"
            $table->unsignedSmallInteger('hierarchy_level'); // 1=PS (top), higher = lower in chain
            $table->boolean('can_supervise')->default(false);
            $table->boolean('is_ps')->default(false);       // exactly one role is PS
            $table->boolean('is_system')->default(false);   // superadmin, cannot be deleted
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
