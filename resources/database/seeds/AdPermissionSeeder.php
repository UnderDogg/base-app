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
        Permission::firstOrCreate([
            'name' => 'ad.access',
            'label' => 'Access Active Directory',
        ]);

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

        Permission::firstOrCreate([
            'name' => 'ad.users.index',
            'label' => 'View Active Directory Users',
        ]);

        Permission::firstOrCreate([
            'name' => 'ad.users.import',
            'label' => 'Import Active Directory Users',
        ]);
    }
}
