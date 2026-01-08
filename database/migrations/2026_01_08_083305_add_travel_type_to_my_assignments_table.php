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
        Schema::table('my_assignments', function (Blueprint $table) {
            $table->smallInteger('travel_type')
                ->default(1) // 1 = OFFICIAL
                ->after('assignment_name');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('my_assignments', function (Blueprint $table) {
            $table->dropColumn('travel_type');
        });
    }

};
