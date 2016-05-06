<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class StaticPermissionSeeder extends Seeder
{
    /**
     * The application permissions.
     *
     * @var array
     */
    protected $permissions = [
        'manage.services'   => 'Manage Services',
        'manage.categories' => 'Manage Categories',
        'manage.computers'  => 'Manage Computers',
        'manage.guides'     => 'Manage Guides',
        'manage.inquiries'  => 'Manage Requests',
        'manage.issues'     => 'Manage Tickets',
        'manage.labels'     => 'Manage Labels',
        'manage.patches'    => 'Manage Patches',
    ];

    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach ($this->permissions as $name => $label) {
            Permission::firstOrCreate(compact('name', 'label'));
        }
    }
}
