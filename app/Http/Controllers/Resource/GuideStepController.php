<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Resource\GuideStepPresenter;
use App\Http\Requests\Resource\GuideStepImagesRequest;
use App\Http\Requests\Resource\GuideStepMoveRequest;
use App\Http\Requests\Resource\GuideStepRequest;
use App\Jobs\Resource\Guide\Step\Move;
use App\Jobs\Resource\Guide\Step\Store;
use App\Jobs\Resource\Guide\Step\Update;
use App\Jobs\Resource\Guide\Step\Upload;
use App\Models\Guide;
use App\Policies\Resource\GuideStepPolicy;

class GuideStepController extends Controller
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
     * Displays the steps for the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
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
     * Displays the form for creating a step for the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id)
    {
        if (GuideStepPolicy::create(auth()->user())) {
            $guide = $this->guide->locate($id);

            $steps = $guide->steps->count() + 1;

            $step = $this->guide->steps()->getRelated();

            $form = $this->presenter->form($guide, $step);

            return view('pages.resources.guides.steps.create', compact('form', 'guide', 'steps'));
        }

        $this->unauthorized();
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
        if (GuideStepPolicy::create(auth()->user())) {
            $guide = $this->guide->locate($id);

            if ($this->dispatch(new Store($request, $guide))) {
                flash()->success('Success!', 'Successfully added step.');

                if ($request->input('action') === 'multiple') {
                    return redirect()->route('resources.guides.steps.create', [$id]);
                }

                return redirect()->route('resources.guides.show', [$id]);
            }

            flash()->error('Error!', 'There was an issue adding a step to this guide. Please try again.');

            return redirect()->route('resources.guides.create', [$id]);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GuideStepRequest $request, $id, $stepPosition)
    {
        if (GuideStepPolicy::edit(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStepByPosition($stepPosition);

            if ($this->dispatch(new Update($request, $guide, $step))) {
                flash()->success('Success!', 'Successfully updated step.');

                if ($request->input('action') === 'multiple') {
                    return redirect()->route('resources.guides.steps.create', [$id]);
                }

                return redirect()->route('resources.guides.steps.index', [$id]);
            }

            flash()->error('Error!', 'There was an issue updating this step. Please try again.');

            return redirect()->route('resources.guides.steps.edit', [$id, $stepPosition]);
        }

        $this->unauthorized();
    }

    /**
     * Deletes the specified guide step.
     *
     * @param int|string $id
     * @param int        $stepPosition
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, $stepPosition)
    {
        if (GuideStepPolicy::destroy(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->findStepByPosition($stepPosition);

            if ($step->delete()) {
                flash()->success('Success!', 'Successfully deleted step.');

                return redirect()->route('resources.guides.steps.index', [$id]);
            }

            flash()->error('Error!', 'There was an issue deleting this step. Please try again.');

            return redirect()->route('resources.guides.steps.index', [$id]);
        }

        $this->unauthorized();
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
     * @return \Illuminate\View\View
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
     * Creates steps for the specified guide per image.
     *
     * @param GuideStepImagesRequest $request
     * @param int|string             $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(GuideStepImagesRequest $request, $id)
    {
        if (GuideStepPolicy::images(auth()->user())) {
            $guide = $this->guide->locate($id);

            $step = $guide->steps()->getRelated();

            $uploaded = $this->dispatch(new Upload($request, $guide, $step));

            if ($uploaded > 0) {
                flash()->success('Success!', "Successfully uploaded: $uploaded images.");

                return redirect()->route('resources.guides.show', [$id]);
            }

            flash()->error('Error!', 'There was an issue uploading images. Please try again.');

            return redirect()->route('resources.guides.images', [$id]);
        }

        $this->unauthorized();
    }
}
