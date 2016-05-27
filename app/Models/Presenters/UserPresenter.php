<?php

namespace App\Models\Presenters;

use App\Models\User;
use Orchestra\Support\Facades\HTML;

class UserPresenter extends Presenter
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Returns the users initials.
     *
     * @return string
     */
    public function initials()
    {
        $expr = '/(?<=\s|^)[a-z]/i';

        preg_match_all($expr, $this->user->name, $matches);

        $result = implode('', $matches[0]);

        return strtoupper($result);
    }

    /**
     * Returns an HTML string of the users label.
     *
     * @return string
     */
    public function label()
    {
        $color = 'primary';

        $name = HTML::entities($this->user->name);

        $icon = HTML::create('i', '', ['class' => 'fa fa-user']);

        return HTML::raw("<span class='label label-$color'>$icon $name</span>");
    }

    /**
     * Returns a large variant of the users label.
     *
     * @return string
     */
    public function labelLarge()
    {
        return HTML::create('span', $this->label(), ['class' => 'label-large']);
    }
}
