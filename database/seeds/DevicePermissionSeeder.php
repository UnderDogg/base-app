<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class DevicePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'computers.index',
            'label' => 'View All Computers',
        ]);

        Permission::firstOrCreate([
            'name' => 'computers.create',
            'label' => 'Create Computers',
        ]);

        Permission::firstOrCreate([
            'name' => 'computers.show',
            'label' => 'View Computers',
        ]);

        Permission::firstOrCreate([
            'name' => 'computers.edit',
            'label' => 'Edit Computers',
        ]);

        Permission::firstOrCreate([
            'name' => 'computers.destroy',
            'label' => 'Delete Computers',
        ]);
    }
}
