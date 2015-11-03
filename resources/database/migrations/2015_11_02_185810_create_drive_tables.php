<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriveTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drives', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('path');
            $table->boolean('is_network')->default(false);
        });

        Schema::create('drive_accounts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->integer('drive_id')->unsigned();
            $table->string('name');

            $table->foreign('drive_id')->references('id')->on('drives');
        });

        Schema::create('drive_permissions', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('drive_items', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();

            $table->integer('drive_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->string('name');

            $table->foreign('drive_id')->references('id')->on('drives');
        });

        Schema::create('drive_item_accounts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('account_id')->unsigned();

            $table->foreign('item_id')->references('id')->on('drive_items');
            $table->foreign('account_id')->references('id')->on('drive_accounts');
        });

        Schema::create('drive_item_account_permissions', function (Blueprint $table)
        {
            $table->integer('account_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            $table->foreign('account_id')->references('id')->on('drive_accounts');
            $table->foreign('permission_id')->references('id')->on('drive_permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drive_item_account_permissions');
        Schema::dropIfExists('drive_item_accounts');
        Schema::dropIfExists('drive_items');
        Schema::dropIfExists('drive_permissions');
        Schema::dropIfExists('drive_accounts');
        Schema::dropIfExists('drives');
    }
}
