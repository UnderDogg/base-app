<?php

namespace App\Http\Controllers\PasswordFolder;

use App\Http\Requests\PasswordFolder\PasswordRequest;
use App\Processors\PasswordProcessor;
use App\Http\Controllers\Controller;

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
     * Displays the current users passwords.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Displays the form to create a password.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a new user password.
     *
     * @param PasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PasswordRequest $request)
    {
        if ($this->processor->store($request)) {
            flash()->success('Success!', 'Successfully created password record.');

            return redirect()->route('passwords.index');
        } else {
            flash()->success('Error!', 'There was an issue creating a password record. Please try again.');

            return redirect()->back();
        }
    }

    /**
     * Displays the users specified password.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return $this->processor->show($id);
    }

    public function edit($id)
    {
        //
    }

    public function update($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
