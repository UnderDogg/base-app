<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class IssuePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Issue Permissions
        Permission::firstOrCreate([
            'name' => 'issues.index.all',
            'label' => 'View All Issues',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.show',
            'label' => 'View Issues',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.edit',
            'label' => 'Edit Issues',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.open',
            'label' => 'Re-Open Issues',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.close',
            'label' => 'Close Issues',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.destroy',
            'label' => 'Delete Issues',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.labels.store',
            'label' => 'Add Labels to Issues',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.users.store',
            'label' => 'Add Users to Issues',
        ]);

        // Issue Attachment Permissions
        Permission::firstOrCreate([
            'name' => 'issue.attachments.show',
            'label' => 'View Issue Attachments',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.attachments.edit',
            'label' => 'Edit Issue Attachments',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.attachments.destroy',
            'label' => 'Delete Issue Attachments',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.attachments.download',
            'label' => 'Download Issue Attachments',
        ]);

        // Issue Comment Permissions
        Permission::firstOrCreate([
            'name' => 'issues.comments.create',
            'label' => 'Create Issue Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.comments.edit',
            'label' => 'Edit Issue Comments',
        ]);

        Permission::firstOrCreate([
            'name' => 'issues.comments.destroy',
            'label' => 'Delete Issue Comments',
        ]);
    }
}
