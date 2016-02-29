<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddClosedByUserIdToIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->integer('closed_by_user_id')->unsigned()->nullable()->after('user_id');

            $table->foreign('closed_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropForeign('issues_closed_by_user_id_foreign');

            $table->dropColumn('closed_by_user_id');
        });
    }
}
