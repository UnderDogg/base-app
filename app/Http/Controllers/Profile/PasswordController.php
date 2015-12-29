<?php

namespace App\Http\Controllers\Profile;

use App\Exceptions\Profile\InvalidPasswordException;
use App\Exceptions\Profile\UnableToChangePasswordException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\PasswordRequest;
use App\Processors\Profile\PasswordProcessor;

class PasswordController extends Controller
{
    /**
     * @var PasswordProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param PasswordProcessor $processor
     */
    public function __construct(PasswordProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the form for changing the current users password.
     *
     * @return \Illuminate\View\View
     */
    public function change()
    {
        return $this->processor->change();
    }

    /**
     * Updates the current users password.
     *
     * @param PasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PasswordRequest $request)
    {
        $flash = flash()->setTimer(3000);

        try {
            $this->processor->update($request);

            $flash->success('Success!', 'Successfully changed password.');

            return redirect()->route('profile.show');
        } catch (InvalidPasswordException $e) {
            $flash->error('Whoops!', 'Looks like your current password was incorrect. Try again.');

            return redirect()->route('profile.password');
        } catch (UnableToChangePasswordException $e) {
            $flash->error('Error!', 'Looks like we had an issue trying to change your password. Please try again.');

            return redirect()->route('profile.password');
        }
    }
}
