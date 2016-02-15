<?php

namespace App\Processors\Resource;

use App\Http\Presenters\Resource\GuideStepPresenter;
use App\Http\Requests\Resource\GuideStepImagesRequest;
use App\Http\Requests\Resource\GuideStepMoveRequest;
use App\Http\Requests\Resource\GuideStepRequest;
use App\Jobs\Resource\Guide\Step\Move;
use App\Jobs\Resource\Guide\Step\Store;
use App\Jobs\Resource\Guide\Step\Update;
use App\Jobs\Resource\Guide\Step\Upload;
use App\Models\Guide;
use App\Models\GuideStep;
use App\Processors\Processor;

class GuideStepProcessor extends Processor
{
    /**
     * @var Guide
     */
    protected $guide;

    /**
     * @var GuideStepPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Guide              $guide
     * @param GuideStepPresenter $presenter
     */
    public function __construct(Guide $guide, GuideStepPresenter $presenter)
    {
        $this->guide = $guide;
        $this->presenter = $presenter;
    }

    /**
     * Displays the specified guide steps.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id)
    {
        $guide = $this->guide->locate($id);

        $this->authorize($guide->steps()->getRelated());

        $steps = $this->presenter->table($guide);

        $navbar = $this->presenter->navbar($guide);

        return view('pages.resources.guides.steps.index', compact('steps', 'navbar', 'guide'));
    }

    /**
     * Displays the form to create a guide step.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        $guide = $this->guide->locate($id);

        $this->authorize($guide->steps()->getRelated());

        $steps = count($guide->steps) + 1;

        $form = $this->presenter->form($guide, new GuideStep());

        return view('pages.resources.guides.steps.create', compact('form', 'guide', 'steps'));
    }

    /**
     * Creates a new step and attaches uploaded images to the step.
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     *
     * @return GuideStep|bool
     */
    public function store(GuideStepRequest $request, $id)
    {
        $guide = $this->guide->locate($id);

        $this->authorize($guide->steps()->getRelated());

        return $this->dispatch(new Store($request, $guide));
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
        $guide = $this->guide->locate($id);

        $step = $guide->findStepByPosition($stepPosition);

        $this->authorize($step);

        $form = $this->presenter->form($guide, $step);

        return view('pages.resources.guides.steps.edit', compact('form', 'guide'));
    }

    /**
     * Updates the specified guide step.
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     * @param int              $stepPosition
     *
     * @return GuideStep|bool
     */
    public function update(GuideStepRequest $request, $id, $stepPosition)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->findStepByPosition($stepPosition);

        $this->authorize($step);

        return $this->dispatch(new Update($request, $guide, $step));
    }

    /**
     * Deletes the specified guide step.
     *
     * @param int|string $id
     * @param int        $stepPosition
     *
     * @return bool|null
     */
    public function destroy($id, $stepPosition)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->findStepByPosition($stepPosition);

        $this->authorize($step);

        return $step->delete();
    }

    /**
     * Moves the guide step to the specified position.
     *
     * @param GuideStepMoveRequest $request
     * @param int|string           $id
     * @param int                  $stepId
     *
     * @return bool
     */
    public function move(GuideStepMoveRequest $request, $id, $stepId)
    {
        $guide = $this->guide->locate($id);

        $step = $guide->findStep($stepId);

        $this->authorize($step);

        return $this->dispatch(new Move($request, $step));
    }

    /**
     * Displays the page for uploading multiple images for the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function images($id)
    {
        $guide = $this->guide->locate($id);

        $this->authorize($guide->steps()->getRelated());

        $form = $this->presenter->formImages($guide);

        return view('pages.resources.guides.steps.upload', compact('form', 'guide'));
    }

    /**
     * Creates a step for the specified guide per uploaded image.
     *
     * @param GuideStepImagesRequest $request
     * @param int|string             $id
     *
     * @return int
     */
    public function upload(GuideStepImagesRequest $request, $id)
    {
        $guide = $this->guide->locate($id);

        $this->authorize('images', $guide->steps()->getRelated());

        $step = $guide->steps()->getRelated();

        return $this->dispatch(new Upload($request, $guide, $step));
    }
}
