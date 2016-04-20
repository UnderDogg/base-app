<?php

namespace App\Http\Requests\PasswordFolder;

use App\Http\Requests\Request;
use App\Models\Password;
use App\Models\PasswordFolder;

class PasswordRequest extends Request
{
    /**
     * The password validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => 'required',
            'password'  => 'required',
        ];
    }

    /**
     * Allows all users to create passwords.
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
     * @param Password       $password
     * @param PasswordFolder $folder
     *
     * @return bool
     */
    public function persist(Password $password, PasswordFolder $folder)
    {
        $password->folder_id = $folder->id;
        $password->title = $this->input('title', $password->title);
        $password->website = $this->input('website', $password->website);
        $password->username = $this->input('username', $password->username);
        $password->password = $this->input('password', $password->password);
        $password->notes = $this->input('notes', $password->notes);

        return $password->save();
    }
}
