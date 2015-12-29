<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\Profile\UpdateRequest;
use App\Processors\Profile\ProfileProcessor;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * @var ProfileProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ProfileProcessor $processor
     */
    public function __construct(ProfileProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the current users profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return $this->processor->show();
    }

    /**
     * Displays the form for editing the current users
     *
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function edit()
    {
        return $this->processor->edit();
    }

    public function update(UpdateRequest $request)
    {
        if ($this->processor->update($request)) {

        } else {

        }
    }
}
