<?php

namespace App\Models;

use Adldap\Laravel\Traits\AdldapUserModelTrait;
use Orchestra\Support\Facades\HTML;
use Orchestra\Model\User as Eloquent;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Eloquent implements AuthorizableContract
{
    use Authorizable, AdldapUserModelTrait;

    /**
     * The user questions pivot table.
     *
     * @var string
     */
    protected $tableQuestionsPivot = 'user_questions';

    /**
     * The hasOne password folder relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function passwordFolder()
    {
        return $this->hasOne(PasswordFolder::class, 'user_id');
    }

    /**
     * The belongsToMany security questions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, $this->tableQuestionsPivot, 'user_id')->withPivot(['answer'])->withTimestamps();
    }

    /**
     * Returns an HTML string of the users label.
     *
     * @return string
     */
    public function getLabel()
    {
        $color = 'primary';

        $name = HTML::entities($this->fullname);

        $icon = HTML::create('i', '', ['class' => 'fa fa-user']);

        return HTML::raw("<span class='label label-$color'>$icon $name</span>");
    }

    /**
     * Returns a large variant of the users label.
     *
     * @return string
     */
    public function getLabelLarge()
    {
        return HTML::create('span', $this->getLabel(), ['class' => 'label-large']);
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
        return $this->newQuery()->where(['forgot_token' => $token])->first();
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
     * Clears the forgot token on the current user.
     *
     * @return bool
     */
    public function clearForgotToken()
    {
        $this->forgot_token = null;

        return $this->save();
    }
}
