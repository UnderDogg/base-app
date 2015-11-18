<?php

namespace App\Http\Controllers\Resource;

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
