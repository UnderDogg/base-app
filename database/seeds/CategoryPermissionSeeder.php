<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class CategoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name'  => 'categories.index',
            'label' => 'View All Categories',
        ]);

        Permission::firstOrCreate([
            'name'  => 'categories.create',
            'label' => 'Create Categories',
        ]);

        Permission::firstOrCreate([
            'name'  => 'categories.edit',
            'label' => 'Edit Categories',
        ]);

        Permission::firstOrCreate([
            'name'  => 'categories.destroy',
            'label' => 'Delete Categories',
        ]);
    }
}
