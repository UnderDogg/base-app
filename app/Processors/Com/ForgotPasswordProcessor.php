<?php

namespace App\Processors\Com;

use Adldap\Models\User;
use App\Http\Requests\Com\ResetRequest;
use COM;
use Adldap\Contracts\Adldap;
use App\Http\Presenters\Com\ForgotPasswordPresenter;
use App\Processors\Processor;

class ForgotPasswordProcessor extends Processor
{
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
     * @param Adldap                  $adldap
     * @param ForgotPasswordPresenter $presenter
     */
    public function __construct(Adldap $adldap, ForgotPasswordPresenter $presenter)
    {
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
        $user = $this->adldap->users()->find($request->input('username'));

        if ($user instanceof User) {
            return view('pages.forgot-password.questions');
        }

        return false;
    }
}
