<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\PatchRequest;
use App\Http\Presenters\Resource\PatchPresenter;
use App\Models\Patch;

class PatchController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patches = $this->presenter->table($this->patch);

        $navbar = $this->presenter->navbar();

        return view('pages.resources.patches.index', compact('patches', 'navbar'));
    }

    /**
     * Show the form for creating a new patch.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function store(PatchRequest $request)
    {
        $patch = $this->dispatch(new Store($request, $this->patch));

        if ($patch instanceof Patch) {
            flash()->success('Success!', 'Successfully created patch.');

            return redirect()->route('resources.patches.show', [$patch->getKey()]);
        } else {
            flash()->error('Error!', 'There was an issue creating a new patch. Please try again.');

            return redirect()->route('resources.patches.index');
        }
    }

    /**
     * Display the specified patch.
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
     * Show the form for editing the specified resource.
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

    /**
     * Update the specified resource in storage.
     *
     * @param PatchRequest $request
     * @param int|string   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PatchRequest $request, $id)
    {
        if ($this->processor->update($request, $id)) {
            flash()->success('Success!', 'Successfully updated patch.');

            return redirect()->route('resources.patches.show', [$id]);
        } else {
            flash()->error('Error!', 'There was an issue updating this patch. Please try again.');

            return redirect()->route('resources.patches.edit', [$id]);
        }
    }

    /**
     * Deletes the specified patch.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->processor->destroy($id)) {
            flash()->success('Success!', 'Successfully deleted patch.');

            return redirect()->route('resources.patches.index');
        } else {
            flash()->error('Error!', 'There was an issue deleting this patch. Please try again.');

            return redirect()->route('resources.patches.show', [$id]);
        }
    }
}
