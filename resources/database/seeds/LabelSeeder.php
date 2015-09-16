<?php

use Illuminate\Database\Seeder;

use App\Models\Label;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labels = Label::getDefault();

        foreach($labels as $label) {
            Label::create($label);
        }
    }
}
