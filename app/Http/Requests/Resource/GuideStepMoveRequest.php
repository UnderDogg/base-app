<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;

class GuideStepMoveRequest extends Request
{
    /**
     * The guide step move validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'position' => 'required|integer',
        ];
    }

    /**
     * Allows all users to move guide steps.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
