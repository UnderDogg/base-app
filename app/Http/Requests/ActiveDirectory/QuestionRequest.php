<?php

namespace App\Http\Requests\ActiveDirectory;

use App\Http\Requests\Request;

class QuestionRequest extends Request
{
    /**
     * The question validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|min:5',
        ];
    }

    /**
     * Allows all users to create security questions.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
