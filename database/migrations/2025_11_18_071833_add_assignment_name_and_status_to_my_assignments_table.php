<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('my_assignments', function (Blueprint $table) {
            $table->string('assignment_name')->after('user_id');
            $table->string('status')->default('pending')->after('assignment_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_assignments', function (Blueprint $table) {
            $table->dropColumn('assignment_name');
            $table->dropColumn('status');
        });
    }
};
