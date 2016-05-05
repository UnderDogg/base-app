<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * List of seeders.
     *
     * @var array
     */
    protected $seeders = [
        LabelSeeder::class,
        InquiryCategorySeeder::class,
    ];

    /**
     * List of permission seeders.
     *
     * @var array
     */
    protected $permissionSeeders = [
        CategoryPermissionSeeder::class,
        DevicePermissionSeeder::class,
        GuidePermissionSeeder::class,
        InquiryPermissionSeeder::class,
        IssuePermissionSeeder::class,
        LabelPermissionSeeder::class,
        ServicePermissionSeeder::class,
    ];

    /**
     * List of seeders to run after permissions are seeded.
     *
     * @var array
     */
    protected $afterPermissionSeeders = [
        AdminPermissionSeeder::class,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach ($this->seeders as $seeder) {
            $this->call($seeder);
        }

        foreach ($this->permissionSeeders as $seeder) {
            $this->call($seeder);
        }

        foreach ($this->afterPermissionSeeders as $seeder) {
            $this->call($seeder);
        }

        Model::reguard();
    }
}
