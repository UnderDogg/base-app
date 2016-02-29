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
            'name'  => 'inquiries.index',
            'label' => 'View All Requests',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.approve',
            'label' => 'Approve Requests',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.open',
            'label' => 'Re-Open Requests',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.close',
            'label' => 'Close Requests',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.show',
            'label' => 'View Requests',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.edit',
            'label' => 'Edit Requests',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.destroy',
            'label' => 'Delete Requests',
        ]);

        // Inquiry Comment Permissions
        Permission::firstOrCreate([
            'name'  => 'inquiries.comments.create',
            'label' => 'Create Request Comments',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.comments.edit',
            'label' => 'Edit Request Comments',
        ]);

        Permission::firstOrCreate([
            'name'  => 'inquiries.comments.destroy',
            'label' => 'Delete Request Comments',
        ]);
    }
}
