<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Show the application welcome screen to the user.
     *
     * @return mixed
     */
    public function index()
    {
        return view('welcome');
    }
}
