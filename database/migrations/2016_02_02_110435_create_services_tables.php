<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('service_records', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('service_id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(1);

            $table->foreign('service_id')->references('id')->on('services')
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
        Schema::dropIfExists('service_records');
        Schema::dropIfExists('services');
    }
}
