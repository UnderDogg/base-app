<?php

namespace App\Http\Controllers\ActiveDirectory;

use App\Http\Controllers\Controller;
use App\Processors\ActiveDirectory\UserAttributeProcessor;

class UserAttributeController extends Controller
{
    /**
     * @var UserAttributeProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param UserAttributeProcessor $processor
     */
    public function __construct(UserAttributeProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays a table of all of the specified users raw attributes.
     *
     * @param string $username
     *
     * @return \Illuminate\View\View
     */
    public function index($username)
    {
        return $this->processor->index($username);
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
        return $this->processor->create($username);
    }

    public function store($username)
    {
        //
    }

    public function show($username, $attribute)
    {
        return $this->processor->show($username, $attribute);
    }

    /**
     * @param string $username
     * @param string $attribute
     *
     * @return \Illuminate\View\View
     */
    public function edit($username, $attribute)
    {
        return $this->processor->edit($username, $attribute);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($username, $attribute)
    {
        if ($this->processor->destroy($username, $attribute)) {
            flash()->success('Success!', "Successfully deleted the $attribute attribute.");

            return redirect()->route('active-directory.users.attributes.index', [$username]);
        } else {
            flash()->error('Error!', "There was an issue deleting the $attribute attribute. Please try again.");

            return redirect()->route('active-directory.users.attributes.index', [$username]);
        }
    }
}
