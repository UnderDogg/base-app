<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComputerTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operating_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('version')->nullable();
            $table->string('service_pack')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('computer_types', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('name');

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('computers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('os_id')->unsigned()->nullable();
            $table->string('dn')->nullable();
            $table->string('ip')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('model')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('type_id')->references('id')->on('computer_types');
            $table->foreign('os_id')->references('id')->on('operating_systems');
        });

        Schema::create('computer_users', function (Blueprint $table) {
            $table->integer('computer_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('computer_id')->references('id')->on('computers');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('computer_status_records', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('computer_id')->unsigned();
            $table->boolean('online')->default(false);
            $table->integer('latency')->nullable();

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
        Schema::dropIfExists('computer_status_records');
        Schema::dropIfExists('computer_users');
        Schema::dropIfExists('computers');
        Schema::dropIfExists('computer_types');
        Schema::dropIfExists('operating_systems');
    }
}
