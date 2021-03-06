<?php

namespace App\Http\Requests\Resource;

use App\Http\Requests\Request;

class PatchComputerRequest extends Request
{
    /**
     * Returns the computer patch rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'computers.*' => 'exists:computers,id',
            'patched'     => 'min:18|max:19',
        ];
    }

    /**
     * Allows all users to add computers to patches.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
