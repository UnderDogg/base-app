<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The questions table.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * The user questions pivot table.
     *
     * @var string
     */
    protected $tableQuestionsPivot = 'user_questions';

    /**
     * The fillable question attributes.
     *
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * The belongsToMany users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, $this->tableQuestionsPivot, 'question_id');
    }

    /**
     * Returns an array of the default security questions.
     *
     * @return array
     */
    public static function getDefault()
    {
        return [
            "What is your pet's name?",
            'In what year was your father born?',
            'What is your mothers maiden name?',
            'What was your childhood nickname?',
            'What is the name of your favorite childhood friend?',
            'In what city or town did your mother and father meet?',
            'What is the middle name of your oldest child?',
            'What is your favorite team?',
            'What is your favorite movie?',
            'What was your favorite sport in high school?',
            'What was your favorite food as a child?',
            'What was the make and model of your first car?',
            'What was the name of the hospital where you were born?',
        ];
    }
}
