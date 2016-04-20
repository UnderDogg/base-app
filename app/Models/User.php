<?php

namespace App\Models;

use Adldap\Laravel\Traits\AdldapUserModelTrait;
use App\Models\Traits\HasAvatar;
use App\Models\Traits\HasFilesTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Orchestra\Support\Facades\HTML;
use Stevebauman\Authorization\Traits\UserRolesTrait;

class User extends Model implements AuthorizableContract, AuthenticatableContract
{
    use Authorizable;
    use Authenticatable;
    use UserRolesTrait;
    use AdldapUserModelTrait;
    use HasFilesTrait;
    use HasAvatar;

    /**
     * The users hidden attributes.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at',
        'email',
        'password',
        'remember_token',
        'forgot_token',
        'reset_token',
        'from_ad',
    ];

    /**
     * The user questions pivot table.
     *
     * @var string
     */
    protected $tableQuestionsPivot = 'user_questions';

    /**
     * {@inheritdoc}
     */
    public function avatars()
    {
        return $this->files();
    }

    /**
     * The hasOne password folder relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function passwordFolder()
    {
        return $this->hasOne(PasswordFolder::class);
    }

    /**
     * The belongsToMany security questions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, $this->tableQuestionsPivot, 'user_id')
            ->withPivot(['answer'])
            ->withTimestamps();
    }

    /**
     * Returns the users initials.
     *
     * @return string
     */
    public function getInitialsAttribute()
    {
        $name = explode(' ', $this->name);

        if (count($name) > 1) {
            list($first, $last) = $name;
        } else {
            list($first) = $name;

            $last = null;
        }

        $firstInitial = substr(strtoupper($first), 0, 1);
        $lastInitial = substr(strtoupper($last), 0, 1);

        return strtoupper($firstInitial.$lastInitial);
    }

    /**
     * Returns an HTML string of the users label.
     *
     * @return string
     */
    public function getLabelAttribute()
    {
        $color = 'primary';

        $name = HTML::entities($this->name);

        $icon = HTML::create('i', '', ['class' => 'fa fa-user']);

        return HTML::raw("<span class='label label-$color'>$icon $name</span>");
    }

    /**
     * Returns a large variant of the users label.
     *
     * @return string
     */
    public function getLabelLargeAttribute()
    {
        return HTML::create('span', $this->label, ['class' => 'label-large']);
    }

    /**
     * Locates a user by the specified attribute and value.
     *
     * @param int|string $attribute
     * @param mixed      $value
     *
     * @return null|User
     */
    public function locateBy($attribute, $value)
    {
        return $this->newQuery()->where([$attribute => $value])->first();
    }

    /**
     * Locates a user by the specified forgot token.
     *
     * @param string $token
     *
     * @return null|User
     */
    public function locateByForgotToken($token)
    {
        return $this->locateBy('forgot_token', $token);
    }

    /**
     * Locates a user by the specified reset token.
     *
     * @param string $token
     *
     * @return User|null
     */
    public function locateByResetToken($token)
    {
        return $this->locateBy('reset_token', $token);
    }

    /**
     * Generates a forgot token on the current user.
     *
     * @return bool
     */
    public function generateForgotToken()
    {
        $this->forgot_token = uuid();

        if ($this->save()) {
            return $this->forgot_token;
        }

        return false;
    }

    /**
     * Generates a reset token on the current user.
     *
     * @return bool
     */
    public function generateResetToken()
    {
        $this->reset_token = uuid();

        if ($this->save()) {
            return $this->reset_token;
        }

        return false;
    }

    /**
     * Clears the forgot token on the current user.
     *
     * @return bool
     */
    public function clearForgotToken()
    {
        $this->forgot_token = null;

        return $this->save();
    }

    /**
     * Clears the reset token on the current user.
     *
     * @return bool
     */
    public function clearResetToken()
    {
        $this->reset_token = null;

        return $this->save();
    }
}
