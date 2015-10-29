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
        $ignore = $this->route('questions');

        return [
            'content' => "required|min:5|unique:questions,content,$ignore",
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

    /**
     * The custom validation messages for questions.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'unique' => 'This question already exists.',
        ];
    }
}
