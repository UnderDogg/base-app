<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class CommentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'comments.create',
            'label' => 'Create Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'comments.edit',
            'label' => 'Edit Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'comments.destroy',
            'label' => 'Delete Comments',
        ]);
    }
}
