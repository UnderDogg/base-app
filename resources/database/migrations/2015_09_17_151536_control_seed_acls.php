<?php

use Orchestra\Model\Role;
use Orchestra\Support\Facades\ACL;
use Orchestra\Support\Facades\Foundation;
use Illuminate\Database\Migrations\Migration;

class ControlSeedAcls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $acl = ACL::make('ithub');

        $acl->attach(Foundation::memory());

        $actions = ['View All Issues', 'Update issue', 'Create Issue'];

        $acl->roles()->attach(Role::lists('name')->all());

        $acl->actions()->attach($actions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
