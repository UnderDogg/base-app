<?php

use App\Models\ComputerType;
use Illuminate\Database\Seeder;

class ComputerTypeSeeder extends Seeder
{
    /**
     * The default computer types to seed.
     *
     * @var array
     */
    protected $types = [
        'Workstation',
        'Server',
        'Switch',
        'Router',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->types as $name) {
            ComputerType::firstOrCreate(compact('name'));
        }
    }
}
