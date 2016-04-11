<?php

namespace App\Http\Requests\ActiveDirectory;

use App\Http\Requests\Request;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class SetupQuestionRequest extends Request
{
    /**
     * The security question setup request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'required|integer',
            'answer'   => 'required',
        ];
    }

    /**
     * Allows all users to setup security questions.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Save the changes.
     *
     * @param User $user
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function persist(User $user)
    {
        $question = Question::findOrFail($this->input('question'));

        $answer = Crypt::encrypt($this->input('answer'));

        return $user->questions()->save($question, ['answer' => $answer]);
    }
}
