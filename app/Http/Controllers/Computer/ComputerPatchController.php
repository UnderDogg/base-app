<?php

namespace App\Http\Controllers\Computer;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Computer\ComputerPatchPresenter;
use App\Models\Computer;

class ComputerPatchController extends Controller
{
    /**
     * @var Computer
     */
    protected $computer;

    /**
     * @var ComputerPatchPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Computer               $computer
     * @param ComputerPatchPresenter $presenter
     */
    public function __construct(Computer $computer, ComputerPatchPresenter $presenter)
    {
        $this->computer = $computer;
        $this->presenter = $presenter;
    }

    public function index($computerId)
    {
        $computer = $this->computer->findOrFail($computerId);

        $navbar = $this->presenter->navbar($computer);

        $patches = $this->presenter->table($computer);
        
        return view('pages.computers.patches.index', compact('computer', 'navbar', 'patches'));
    }
}
