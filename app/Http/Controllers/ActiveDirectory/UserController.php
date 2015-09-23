<?php

namespace App\Http\Controllers\ActiveDirectory;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ActiveDirectory\UserImportRequest;
use App\Processors\ActiveDirectory\UserProcessor;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var UserProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param UserProcessor $processor
     */
    public function __construct(UserProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all active directory users.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return $this->processor->index($request);
    }

    /**
     * Imports an active directory user.
     *
     * @param UserImportRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserImportRequest $request)
    {
        $user = $this->processor->store($request);

        if ($user instanceof User) {
            $name = $user->fullname;

            flash()->success('Success!', "Successfully added user $name.");

            return redirect()->back();
        } else {
            flash()->error('Error!', 'There was a problem adding a user. Please try again.');

            return redirect()->back();
        }
    }
}
