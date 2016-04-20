<?php

namespace App\Http\Requests\PasswordFolder;

use App\Http\Requests\Request;
use App\Models\PasswordFolder;
use Illuminate\Support\Facades\Auth;

class SetupRequest extends Request
{
    /**
     * The password setup validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pin'               => 'required|confirmed|min:4',
            'pin_confirmation'  => 'required|min:4',
        ];
    }

    /**
     * Allows all users to setup their own password folders.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Persist the changes.
     *
     * @param PasswordFolder $folder
     *
     * @return bool
     */
    public function persist(PasswordFolder $folder)
    {
        $folder->user_id = Auth::user()->id;
        $folder->locked = true;
        $folder->uuid = uuid();
        $folder->pin = $this->input('pin');

        return $folder->save();
    }
}
