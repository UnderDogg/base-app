<?php

namespace App\Models;

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
}
