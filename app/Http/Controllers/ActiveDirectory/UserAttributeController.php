<?php

namespace App\Http\Controllers\ActiveDirectory;

use App\Processors\ActiveDirectory\UserAttributeProcessor;
use App\Http\Controllers\Controller;

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

    public function create()
    {
        //
    }

    public function store($username)
    {
        //
    }

    public function edit($username, $attribute)
    {
        return $this->processor->edit($username, $attribute);
    }

    public function update($username, $attribute)
    {
        //
    }

    public function destroy($username, $attribute)
    {
        //
    }
}
