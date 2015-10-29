<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('content');

            // Make sure every question is unique.
            $table->unique(['content']);
        });

        Schema::create('user_questions', function(Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->string('answer');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('question_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_questions');
        Schema::dropIfExists('questions');
    }
}
