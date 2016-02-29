<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->boolean('closed')->default(false);
            $table->boolean('approved')->default(false);
            $table->string('title');
            $table->text('description')->nullable();

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('set null');
        });

        Schema::create('inquiry_comments', function (Blueprint $table) {
            $table->integer('inquiry_id')->unsigned();
            $table->integer('comment_id')->unsigned();

            $table->foreign('inquiry_id')->references('id')->on('inquiries');
            $table->foreign('comment_id')->references('id')->on('comments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiry_comments');
        Schema::dropIfExists('inquiries');
    }
}
