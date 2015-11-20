<?php

namespace App\Http\Requests\Device;

use App\Http\Requests\Request;

class DriveRequest extends Request
{
    /**
     * The drive request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        $drive = $this->route('drives');

        return [
            'name' => "required|unique:drives,name,$drive",
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
