<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class InquiryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'inquiries.index',
            'label' => 'Create Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'inquiries.approve',
            'label' => 'Create Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'inquiries.open',
            'label' => 'Create Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'inquiries.close',
            'label' => 'Create Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'inquiries.show',
            'label' => 'Create Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'inquiries.edit',
            'label' => 'Create Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'inquiries.destroy',
            'label' => 'Create Comments',
        ]);
    }
}
