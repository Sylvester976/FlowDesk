<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->foreignId('directorate_id')
                ->constrained()
                ->restrictOnDelete();
            $table->unsignedBigInteger('head_user_id')->nullable(); // set after users exist
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['name', 'directorate_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
