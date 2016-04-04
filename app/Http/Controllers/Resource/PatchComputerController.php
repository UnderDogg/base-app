<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Resource\PatchComputerPresenter;
use App\Http\Requests\Resource\PatchComputerRequest;
use App\Jobs\Resource\Patch\Computer\Store;
use App\Models\Patch;

class PatchComputerController extends Controller
{
    /**
     * @var Patch
     */
    protected $patch;

    /**
     * @var PatchComputerPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Patch                  $patch
     * @param PatchComputerPresenter $presenter
     */
    public function __construct(Patch $patch, PatchComputerPresenter $presenter)
    {
        $this->patch = $patch;
        $this->presenter = $presenter;
    }

    /**
     * Attaches computers to the specified patch.
     *
     * @param PatchComputerRequest $request
     * @param                      $patchId
     *
     * @return mixed
     */
    public function store(PatchComputerRequest $request, $patchId)
    {
        $patch = $this->patch->findOrFail($patchId);

        if ($this->dispatch(new Store($request, $patch))) {
            flash()->success('Success!', 'Successfully added computers.');

            return redirect()->route('resources.patches.show', [$patch->getKey()]);
        } else {
            flash()->error('Error!', 'There was an issue attaching computers to this patch. Please try again.');

            return redirect()->route('resources.patches.show', [$patchId]);
        }
    }
}
