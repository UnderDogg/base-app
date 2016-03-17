<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComputerPatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('computer_patches', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('computer_id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();

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
        Schema::dropIfExists('computer_patches');
    }
}
