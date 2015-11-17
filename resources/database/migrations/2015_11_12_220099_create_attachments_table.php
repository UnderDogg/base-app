<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table)
        {
            $table->increments('id');
            $table->timestamps();
            $table->string('path');
            $table->string('title')->nullable();
            $table->integer('attachable_id')->unsigned();
            $table->string('attachable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attachments');
    }
}