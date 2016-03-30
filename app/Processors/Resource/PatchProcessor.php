<?php

namespace App\Processors\Resource;

use App\Http\Presenters\Resource\PatchPresenter;
use App\Http\Requests\Resource\PatchRequest;
use App\Jobs\Resource\Patch\Store;
use App\Models\Patch;
use App\Processors\Processor;

class PatchProcessor extends Processor
{
    /**
     * @var Patch
     */
    protected $patch;

    /**
     * @var PatchPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Patch          $patch
     * @param PatchPresenter $presenter
     */
    public function __construct(Patch $patch, PatchPresenter $presenter)
    {
        $this->patch = $patch;
        $this->presenter = $presenter;
    }

    /**
     * Displays all patches.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patches = $this->presenter->table($this->patch);

        $navbar = $this->presenter->navbar();

        return view('pages.resources.patches.index', compact('patches', 'navbar'));
    }

    /**
     * Displays the form for creating a new patch.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $form = $this->presenter->form($this->patch);

        return view('pages.resources.patches.create', compact('form'));
    }

    /**
     * Creates a new patch.
     *
     * @param PatchRequest $request
     *
     * @return Patch|bool
     */
    public function store(PatchRequest $request)
    {
        $patch = $this->patch->newInstance();

        return $this->dispatch(new Store($request, $patch));
    }

    /**
     * Displays the specified patch.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $patch = $this->patch->findOrFail($id);

        return view('pages.resources.patches.show', compact('patch'));
    }

    /**
     * Displays the form for editing the specified patch.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $patch = $this->patch->findOrFail($id);

        $form = $this->presenter->form($patch);

        return view('pages.resources.patches.edit', compact('form'));
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
