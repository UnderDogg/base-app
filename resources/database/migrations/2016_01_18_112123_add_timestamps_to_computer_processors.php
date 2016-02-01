<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTimestampsToComputerProcessors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('computer_processors', function (Blueprint $table) {
            $table->nullableTimestamps();
        });

        Schema::table('computer_processor_records', function (Blueprint $table) {
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('computer_processors', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('computer_processor_records', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
