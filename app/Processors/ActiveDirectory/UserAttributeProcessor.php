<?php

namespace App\Processors\ActiveDirectory;

use Adldap\Contracts\Adldap;
use Adldap\Models\User;
use App\Http\Presenters\ActiveDirectory\UserAttributePresenter;
use App\Processors\Processor;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserAttributeProcessor extends Processor
{
    /**
     * @var UserAttributePresenter
     */
    protected $presenter;

    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * Constructor.
     *
     * @param UserAttributePresenter $presenter
     * @param Adldap                 $adldap
     */
    public function __construct(UserAttributePresenter $presenter, Adldap $adldap)
    {
        $this->presenter = $presenter;
        $this->adldap = $adldap;
    }

    /**
     * Displays a table of all of the specified users attributes.
     *
     * @param string $username
     *
     * @return \Illuminate\View\View
     */
    public function index($username)
    {
        $user = $this->adldap->users()->find($username);

        if ($user instanceof User) {
            $attributes = $this->presenter->table($user);

            $navbar = $this->presenter->navbar($user);

            return view('pages.active-directory.users.attributes.index', compact('user', 'attributes', 'navbar'));
        }

        throw new NotFoundHttpException();
    }

    /**
     * Displays the form for creating an attribute on the specified user.
     *
     * @param string $username
     *
     * @return \Illuminate\View\View
     */
    public function create($username)
    {
        $user = $this->adldap->users()->find($username);

        if ($user instanceof User) {
            $form = $this->presenter->form($user);

            return view('pages.active-directory.users.attributes.create', compact('user', 'form'));
        }

        throw new NotFoundHttpException();
    }

    public function store($username)
    {
        //
    }

    /**
     * Displays the form for editing the specified users attribute.
     *
     * @param string $username
     * @param string $attribute
     *
     * @return \Illuminate\View\View
     */
    public function edit($username, $attribute)
    {
        $user = $this->adldap->users()->find($username);

        if ($user instanceof User && $user->hasAttribute($attribute)) {
            $form = $this->presenter->form($user, $attribute);

            return view('pages.active-directory.users.attributes.edit', compact('user', 'attribute', 'form'));
        }

        throw new NotFoundHttpException();
    }

    public function update($username, $attribute)
    {
        //
    }

    /**
     * Deletes the users specified attribute.
     *
     * @param string $username
     * @param string $attribute
     *
     * @return bool
     */
    public function destroy($username, $attribute)
    {
        $user = $this->adldap->users()->find($username);

        if ($user instanceof User && $user->hasAttribute($attribute)) {
            return $user->deleteAttribute($attribute);
        }

        throw new NotFoundHttpException();
    }
}
