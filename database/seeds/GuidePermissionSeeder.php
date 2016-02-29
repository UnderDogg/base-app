<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class GuidePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Guide Permissions
        Permission::firstOrCreate([
            'name' => 'guides.index.unpublished',
            'label' => 'View Unpublished Guides',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.create',
            'label' => 'Create Guides',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.edit',
            'label' => 'Edit Guides',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.destroy',
            'label' => 'Delete Guides',
        ]);

        // Guide Step Permissions
        Permission::firstOrCreate([
            'name' => 'guides.steps.index',
            'label' => 'View Guide Steps',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.steps.create',
            'label' => 'Create Guide Steps',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.steps.edit',
            'label' => 'Edit Guide Steps',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.steps.images.create',
            'label' => 'Create Guide Steps by Images',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.steps.move',
            'label' => 'Move Guide Steps',
        ]);

        Permission::firstOrCreate([
            'name' => 'guides.steps.destroy',
            'label' => 'Delete Guide Steps',
        ]);
    }
}
