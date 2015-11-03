<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\Request;

class DriveRequest extends Request
{
    /**
     * The drive validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $drive = $this->route('drive');

        return [
            'name' => 'required',
            'path' => "required|unique:drives,path,$drive",
        ];
    }

    /**
     * Allows all users to create drives.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
