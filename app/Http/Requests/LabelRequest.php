<?php

namespace App\Http\Requests;

use App\Models\Label;

class LabelRequest extends Request
{
    /**
     * The label validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $colors = implode(',', Label::getColors());

        return [
            'name'  => 'required|min:3',
            'color' => "required|in:$colors",
        ];
    }

    /**
     * Allow all users to create labels.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
