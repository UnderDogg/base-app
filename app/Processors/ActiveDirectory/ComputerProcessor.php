<?php

namespace App\Processors\ActiveDirectory;

use Adldap\Laravel\Facades\Adldap;
use App\Http\Presenters\ActiveDirectory\ComputerPresenter;
use App\Processors\Processor;

class ComputerProcessor extends Processor
{
    /**
     * @var ComputerPresenter
     */
    protected $presenter;

    /**
     * @var Adldap
     */
    protected $adldap;

    /**
     * Constructor.
     *
     * @parma ComputerPresenter $presenter
     * @param Adldap            $adldap
     */
    public function __construct(ComputerPresenter $presenter, Adldap $adldap)
    {
        $this->presenter = $presenter;
        $this->adldap = $adldap;
    }

    /**
     * Displays all computers in active directory.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('index');

        $computers = $this->presenter->table($this->adldap->computers()->all());

        return view('pages.active-directory.computers.index', compact('computers'));
    }
}
