<?php

use Illuminate\Database\Seeder;

use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::getDefault();

        foreach($questions as $question) {
            Question::firstOrCreate([
                'content' => $question,
            ]);
        }
    }
}
