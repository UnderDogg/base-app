<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUserTokenFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('forgot_token')->nullable();
            $table->string('reset_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('forgot_token', 'users')) {
                $table->dropColumn('forgot_token');
            }

            if (Schema::hasColumn('reset_token', 'users')) {
                $table->dropColumn('reset_token');
            }
        });
    }
}
