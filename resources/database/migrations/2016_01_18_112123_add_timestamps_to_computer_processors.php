<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->timestamps();
        });

        Schema::table('computer_processor_records', function (Blueprint $table) {
            $table->timestamps();
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
