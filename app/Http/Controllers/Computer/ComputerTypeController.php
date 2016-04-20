<?php

namespace App\Http\Controllers\Computer;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Computer\ComputerTypePresenter;
use App\Http\Requests\Computer\ComputerTypeRequest;
use App\Jobs\Computer\Type\Store;
use App\Jobs\Computer\Type\Update;
use App\Models\ComputerType;

class ComputerTypeController extends Controller
{
    /**
     * @var ComputerType
     */
    protected $type;

    /**
     * @var ComputerTypePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param ComputerType          $type
     * @param ComputerTypePresenter $presenter
     */
    public function __construct(ComputerType $type, ComputerTypePresenter $presenter)
    {
        $this->type = $type;
        $this->presenter = $presenter;
    }

    /**
     * Displays all computer types.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $types = $this->presenter->table($this->type);

        $navbar = $this->presenter->navbar();

        return view('pages.computers.types.index', compact('types', 'navbar'));
    }

    /**
     * Displays the form for creating new computer types.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->type);

        return view('pages.computers.types.create', compact('form'));
    }

    /**
     * Creates a new computer type.
     *
     * @param ComputerTypeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ComputerTypeRequest $request)
    {
        $type = $this->type->newInstance();

        if ($this->dispatch(new Store($request, $type))) {
            flash()->success('Success!', 'Successfully created computer type.');

            return redirect()->route('computer-types.index');
        }

        flash()->error('Error!', 'There was an issue creating a computer type. Please try again.');

        return redirect()->route('computer-types.create');
    }

    /**
     * Displays the form for editing the specified computer type.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $type = $this->type->findOrFail($id);

        $form = $this->presenter->form($type);

        return view('pages.computers.types.edit', compact('form'));
    }

    /**
     * Updates the specified computer type.
     *
     * @param ComputerTypeRequest $request
     * @param int|string          $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ComputerTypeRequest $request, $id)
    {
        $type = $this->type->findOrFail($id);

        if ($this->dispatch(new Update($request, $type))) {
            flash()->success('Success!', 'Successfully updated computer type.');

            return redirect()->route('computer-types.index');
        }

        flash()->error('Error!', 'There was an issue updating this computer type. Please try again.');

        return redirect()->route('computer-types.edit', [$id]);
    }

    /**
     * Deletes the specified computer type.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $type = $this->type->findOrFail($id);

        if ($type->delete()) {
            flash()->success('Success!', 'Successfully deleted computer type.');

            return redirect()->route('computer-types.index');
        }

        flash()->error('Error!', 'There was an issue deleting this computer type. Please try again.');

        return redirect()->route('computer-types.index');
    }
}
