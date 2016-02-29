<?php


use App\Models\Permission;
use Illuminate\Database\Seeder;

class ServicePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Service Permissions
        Permission::firstOrCreate([
            'name'  => 'services.index',
            'label' => 'View All Services',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.create',
            'label' => 'Create Services',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.show',
            'label' => 'View Services',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.edit',
            'label' => 'Edit Services',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.destroy',
            'label' => 'Delete Services',
        ]);

        // Service Record Permissions
        Permission::firstOrCreate([
            'name'  => 'services.records.index',
            'label' => 'View All Service Records',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.records.create',
            'label' => 'Create Service Records',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.records.show',
            'label' => 'View Service Records',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.records.edit',
            'label' => 'Edit Service Records',
        ]);

        Permission::firstOrCreate([
            'name'  => 'services.records.destroy',
            'label' => 'Delete Service Records',
        ]);
    }
}
