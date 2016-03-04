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
use App\Policies\Resource\GuideStepPolicy;
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
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function index($id)
    {
        if (GuideStepPolicy::index(auth()->user())) {
            $guide = $this->guide->locate($id);

            $steps = $this->presenter->table($guide);

            $navbar = $this->presenter->navbar($guide);

            return view('pages.resources.guides.steps.index', compact('steps', 'navbar', 'guide'));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form to create a guide step.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function create($id)
    {
        if (GuideStepPolicy::create(auth()->user())) {
            $guide = $this->guide->locate($id);

            $steps = count($guide->steps) + 1;

            $form = $this->presenter->form($guide, new GuideStep());

            return view('pages.resources.guides.steps.create', compact('form', 'guide', 'steps'));
        }

        $this->unauthorized();
    }

    /**
     * Creates a new step and attaches uploaded images to the step.
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     *
     * @return GuideStep|bool
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function store(GuideStepRequest $request, $id)
    {
        if (GuideStepPolicy::create(auth()->user())) {
            $guide = $this->guide->locate($id);

            return $this->dispatch(new Store($request, $guide));
        }

        $this->unauthorized();
    }

    /**
     * Displays the form for editing the specified guide step.
     *
     * @param int|string $id
     * @param int        $stepPosition
     *
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function edit($id, $stepPosition)
    {
        if (GuideStepPolicy::edit(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStepByPosition($stepPosition);

            $form = $this->presenter->form($guide, $step);

            return view('pages.resources.guides.steps.edit', compact('form', 'guide'));
        }

        $this->unauthorized();
    }

    /**
     * Updates the specified guide step.
     *
     * @param GuideStepRequest $request
     * @param int|string       $id
     * @param int              $stepPosition
     *
     * @return GuideStep|bool
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function update(GuideStepRequest $request, $id, $stepPosition)
    {
        if (GuideStepPolicy::edit(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStepByPosition($stepPosition);

            return $this->dispatch(new Update($request, $guide, $step));
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified guide step.
     *
     * @param int|string $id
     * @param int        $stepPosition
     *
     * @return bool|null
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function destroy($id, $stepPosition)
    {
        if (GuideStepPolicy::destroy(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStepByPosition($stepPosition);

            return $step->delete();
        }

        $this->unauthorized();
    }

    /**
     * Moves the guide step to the specified position.
     *
     * @param GuideStepMoveRequest $request
     * @param int|string           $id
     * @param int                  $stepId
     *
     * @return bool
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function move(GuideStepMoveRequest $request, $id, $stepId)
    {
        if (GuideStepPolicy::move(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStep($stepId);

            return $this->dispatch(new Move($request, $step));
        }

        $this->unauthorized();
    }

    /**
     * Displays the page for uploading multiple images for the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function images($id)
    {
        if (GuideStepPolicy::images(auth()->user())) {
            $guide = $this->guide->locate($id);

            $form = $this->presenter->formImages($guide);

            return view('pages.resources.guides.steps.upload', compact('form', 'guide'));
        }

        $this->unauthorized();
    }

    /**
     * Creates a step for the specified guide per uploaded image.
     *
     * @param GuideStepImagesRequest $request
     * @param int|string             $id
     *
     * @return int
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function upload(GuideStepImagesRequest $request, $id)
    {
        if (GuideStepPolicy::images(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->steps()->getRelated();

            return $this->dispatch(new Upload($request, $guide, $step));
        }

        $this->unauthorized();
    }
}
