<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patches', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('title');
            $table->text('description')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('set null');
        });

        Schema::create('patch_computers', function (Blueprint $table) {
            $table->integer('patch_id')->unsigned();
            $table->integer('computer_id')->unsigned();

            $table->foreign('patch_id')->references('id')->on('patches')
                ->onDelete('cascade');

            $table->foreign('computer_id')->references('id')->on('computers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patch_computers');
        Schema::dropIfExists('patches');
    }
}
