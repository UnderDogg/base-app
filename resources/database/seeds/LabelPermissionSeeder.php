<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class LabelPermissionSeeder extends Seeder
{
    /**
     * Execute the job.
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'labels.index',
            'label' => 'View All Labels',
        ]);

        Permission::firstOrCreate([
            'name' => 'labels.create',
            'label' => 'Create Labels',
        ]);

        Permission::firstOrCreate([
            'name' => 'labels.edit',
            'label' => 'Edit Labels',
        ]);

        Permission::firstOrCreate([
            'name' => 'labels.destroy',
            'label' => 'Delete Labels',
        ]);
    }
}
