<?php

namespace App\Http\Controllers\Resource;

use App\Http\Requests\Resource\PatchRequest;
use App\Models\Patch;
use App\Processors\Resource\PatchProcessor;
use App\Http\Controllers\Controller;

class PatchController extends Controller
{
    /**
     * @var PatchProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param PatchProcessor $processor
     */
    public function __construct(PatchProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays all patches.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->processor->index();
    }

    /**
     * Show the form for creating a new patch.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->processor->create();
    }

    /**
     * Creates a new patch.
     *
     * @param  PatchRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PatchRequest $request)
    {
        $patch = $this->processor->store($request);

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
        return $this->processor->show($id);
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
        return $this->processor->edit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PatchRequest  $request
     * @param int|string    $id
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
