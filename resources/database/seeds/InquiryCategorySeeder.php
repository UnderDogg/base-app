<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class InquiryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $belongsTo = 'inquiries';

        $categories = [
            'Password Reset',
            'Other',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate([
                'name'       => $category,
                'belongs_to' => $belongsTo,
            ]);
        }
    }
}
