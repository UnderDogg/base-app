<?php

namespace App\Http\Requests\Profile;

use App\Http\Requests\Request;
use App\Models\User;

class UpdateRequest extends Request
{
    /**
     * The profile update validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|min:3',
            'email'     => 'required|email',
        ];
    }

    /**
     * Allows all users to update their own profiles.
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
     * @param User $user
     *
     * @return bool
     */
    public function persist(User $user)
    {
        $user->name = $this->input('full_name', $user->name);
        $user->email = $this->input('email', $user->email);

        return $user->save();
    }
}
