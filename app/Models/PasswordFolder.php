<?php

namespace App\Models;

use App\Http\Requests\PasswordUnlockRequest;
use App\Models\Traits\HasUserTrait;
use Illuminate\Hashing\BcryptHasher;

class PasswordFolder extends Model
{
    use HasUserTrait;

    /**
     * The password folder table.
     *
     * @var string
     */
    protected $table = 'password_folders';

    /**
     * The hidden password folder attributes.
     *
     * @var array
     */
    protected $hidden = [
        'pin',
        'uuid',
    ];

    /**
     * The guarded password folder attributes.
     *
     * @var array
     */
    protected $guarded = [
        'pin',
        'uuid',
    ];

    /**
     * The hasMany passwords relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passwords()
    {
        return $this->hasMany(Password::class, 'folder_id');
    }

    /**
     * Unlocks a password folder by checking the specified
     * pin against the password folder pin.
     *
     * @param PasswordUnlockRequest $request
     *
     * @return bool
     */
    public function unlock(PasswordUnlockRequest $request)
    {
        $hasher = new BcryptHasher();

        if($hasher->check($request->input('pin'), $this->pin)) {
            // Store the UUID in the users session so they can have
            // access to it for as long as the session exists
            $request->session()->put($this->uuid, $this->uuid);

            return true;
        }

        return false;
    }
}
