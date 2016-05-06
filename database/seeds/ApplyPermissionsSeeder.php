<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class ApplyPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::whereName(Role::getAdministratorName())->firstOrFail();

        Permission::all()->map(function ($permission) use ($role) {
            $role->grant($permission);
        });
    }
}
