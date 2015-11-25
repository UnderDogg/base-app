<?php

namespace App\Http\Controllers\Resource;

use App\Http\Requests\Resource\GuideStepMoveRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Processors\Resource\GuideStepProcessor;
use App\Http\Requests\Resource\GuideStepRequest;
use App\Http\Controllers\Controller;

class GuideStepController extends Controller
{
    /**
     * @var GuideStepProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param GuideStepProcessor $processor
     */
    public function __construct(GuideStepProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the steps for the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        return $this->processor->index($id);
    }

    /**
     * Displays the form for creating a step for the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        return $this->processor->create($id);
    }

    /**
     * Creates a step for the specified guide.
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GuideStepRequest $request, $id)
    {
        if ($this->processor->store($request, $id)) {
            flash()->success('Success!', 'Successfully added step.');

            return redirect()->route('resources.guides.show', [$id]);
        } else {
            flash()->error('Error!', 'There was an issue adding a step to this guide. Please try again.');

            return redirect()->route('resources.guides.show', [$id]);
        }
    }

    /**
     * Displays the form for editing the specified guide step.
     *
     * @param int|string $id
     * @param int        $stepPosition
     *
     * @return \Illuminate\View\View
     */
    public function edit($id, $stepPosition)
    {
        return $this->processor->edit($id, $stepPosition);
    }

    /**
     * Updates the specified guide step.
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     * @param int              $stepPosition
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GuideStepRequest $request, $id, $stepPosition)
    {
        if ($this->processor->update($request, $id, $stepPosition)) {
            flash()->success('Success!', 'Successfully updated step.');

            return redirect()->route('resources.guides.steps.index', [$id]);
        } else {
            flash()->error('Error!', 'There was an issue updating this step. Please try again.');

            return redirect()->route('resources.guides.steps.edit', [$id, $stepPosition]);
        }
    }

    /**
     * Moves the specified guide step to the specified position.
     *
     * @param GuideStepMoveRequest $request
     * @param int|string           $id
     * @param int                  $stepId
     *
     * @return bool
     */
    public function move(GuideStepMoveRequest $request, $id, $stepId)
    {
        return $this->processor->move($request, $id, $stepId);
    }

    /**
     * Returns a download response for the specified guide step image.
     *
     * @param int|string $id
     * @param int|string $stepId
     * @param string     $fileUuid
     *
     * @return BinaryFileResponse
     */
    public function download($id, $stepId, $fileUuid)
    {
        $response = $this->processor->download($id, $stepId, $fileUuid);

        if ($response instanceof BinaryFileResponse) {
            return $response;
        }

        abort(404);
    }
}
