<?php

namespace App\Http\Requests\Profile;

use App\Exceptions\Profile\InvalidPasswordException;
use App\Exceptions\Profile\UnableToChangePasswordException;
use App\Http\Requests\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PasswordRequest extends Request
{
    /**
     * The password request validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password'      => 'required',
            'password'              => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
        ];
    }

    /**
     * Allows all users to change their passwords.
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
     * @throws InvalidPasswordException
     * @throws UnableToChangePasswordException
     *
     * @return bool
     */
    public function persist(User $user)
    {
        $credentials['password'] = $this->input('current_password');
        $credentials['email'] = $user->email;

        if (!Auth::validate($credentials)) {
            throw new InvalidPasswordException();
        }

        // Change the users password.
        $user->password = $this->input('password');

        if (!$user->save()) {
            throw new UnableToChangePasswordException();
        }
    }
}
