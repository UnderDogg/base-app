<?php

namespace App\Processors\Com;

use COM;
use App\Models\User;
use Adldap\Models\User as AdldapUser;
use App\Http\Requests\Com\ResetRequest;
use Adldap\Contracts\Adldap;
use App\Http\Presenters\Com\ForgotPasswordPresenter;
use App\Processors\Processor;

class ForgotPasswordProcessor extends Processor
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * @var ForgotPasswordPresenter
     */
    protected $presenter;

    /**
     * @var COM
     */
    protected $com;

    /**
     * The COM command to execute.
     *
     * @var string
     */
    protected $command = 'LDAP:';

    /**
     * Constructor.
     *
     * @param User                    $user
     * @param Adldap                  $adldap
     * @param ForgotPasswordPresenter $presenter
     */
    public function __construct(User $user, Adldap $adldap, ForgotPasswordPresenter $presenter)
    {
        $this->user = $user;
        $this->adldap = $adldap;
        $this->presenter = $presenter;
        $this->com = new COM($this->command);
    }

    /**
     * Displays the form to reset a users password.
     *
     * @return \Illuminate\View\View
     */
    public function reset()
    {
        $form = $this->presenter->form();

        return view('pages.forgot-password.reset', compact('form'));
    }

    /**
     * Displays a form of all of the users security questions.
     *
     * @param ResetRequest $request
     *
     * @return bool|\Illuminate\View\View
     */
    public function questions(ResetRequest $request)
    {
        $profile = $this->adldap->users()->find($request->input('username'));

        if ($profile instanceof AdldapUser) {
            $user = $this->user->where('email', $profile->getEmail())->first();

            if ($user instanceof User && count($user->questions) > 0) {
                return view('pages.forgot-password.questions');
            }
        }

        return false;
    }
}
