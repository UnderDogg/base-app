<?php

namespace App\Http\Controllers\Com;

use App\Http\Requests\Com\FindRequest;
use App\Http\Requests\Com\QuestionRequest;
use Illuminate\Contracts\View\View;
use App\Http\Requests\Com\DiscoverRequest;
use App\Processors\Com\ForgotPasswordProcessor;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * @var ForgotPasswordProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ForgotPasswordProcessor $processor
     */
    public function __construct(ForgotPasswordProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the form to reset a users password.
     *
     * @return \Illuminate\View\View
     */
    public function discover()
    {
        return $this->processor->discover();
    }

    public function find(DiscoverRequest $request)
    {
        $token = $this->processor->find($request);

        if (is_string($token)) {
            return redirect()->route('auth.forgot-password.questions', [$token]);
        }

        $message = "Hmmm, it looks like we couldn't locate the user you're looking for. Try again!";

        flash()->error('Error', $message);

        return redirect()->route('auth.forgot-password.discover');
    }

    /**
     * Displays the form for answering the users security questions.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function questions($token = '')
    {
        $view = $this->processor->questions($token);

        if ($view instanceof View) {
            return $view;
        }

        return redirect()->route('auth.forgot-password.discover');
    }

    public function reset(QuestionRequest $request, $token)
    {
        return $this->processor->reset($request, $token);
    }
}
