<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class AdPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // AD Access Permission
        Permission::firstOrCreate([
            'name' => 'ad.access',
            'label' => 'Access Active Directory',
        ]);

        // AD Computer Permissions
        Permission::firstOrCreate([
            'name' => 'ad.computers.index',
            'label' => 'View Active Directory Computers',
        ]);

        Permission::firstOrCreate([
            'name' => 'ad.computers.import',
            'label' => 'Import Active Directory Computers',
        ]);

        Permission::firstOrCreate([
            'name' => 'ad.computers.import',
            'label' => 'Import Active Directory Computers',
        ]);

        // AD User Permissions
        Permission::firstOrCreate([
            'name' => 'ad.users.index',
            'label' => 'View Active Directory Users',
        ]);

        Permission::firstOrCreate([
            'name' => 'ad.users.create',
            'label' => 'Create Active Directory Users',
        ]);

        Permission::firstOrCreate([
            'name' => 'ad.users.edit',
            'label' => 'Edit Active Directory Users',
        ]);

        Permission::firstOrCreate([
            'name' => 'ad.users.import',
            'label' => 'Import Active Directory Users',
        ]);
    }
}
