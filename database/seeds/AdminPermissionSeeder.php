<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $administrator = Role::whereName(Role::getAdministratorName())->firstOrFail();

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $administrator->grant($permission);
        }
    }
}
