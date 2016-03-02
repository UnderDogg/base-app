<?php

namespace App\Processors\Resource;

use App\Http\Presenters\Resource\GuidePresenter;
use App\Http\Requests\Resource\GuideRequest;
use App\Jobs\Resource\Guide\Favorite;
use App\Jobs\Resource\Guide\Store;
use App\Jobs\Resource\Guide\Update;
use App\Models\Guide;
use App\Policies\Resource\GuidePolicy;
use App\Processors\Processor;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuideProcessor extends Processor
{
    /**
     * @var Guide
     */
    protected $guide;

    /**
     * @var GuidePresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Guide          $guide
     * @param GuidePresenter $presenter
     */
    public function __construct(Guide $guide, GuidePresenter $presenter)
    {
        $this->guide = $guide;
        $this->presenter = $presenter;
    }

    /**
     * Displays a table of all guides.
     *
     * @param bool|false $favorites
     *
     * @return \Illuminate\View\View
     */
    public function index($favorites = false)
    {
        $guides = $this->presenter->table($this->guide, $favorites);

        $navbar = $this->presenter->navbar();

        return view('pages.resources.guides.index', compact('guides', 'navbar'));
    }

    /**
     * Displays the form to create a new guide.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (GuidePolicy::create(auth()->user())) {
            $form = $this->presenter->form($this->guide);

            return view('pages.resources.guides.create', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Creates a new guide.
     *
     * @param GuideRequest $request
     *
     * @return bool
     */
    public function store(GuideRequest $request)
    {
        if (GuidePolicy::create(auth()->user())) {
            $guide = $this->guide->newInstance();

            return $this->dispatch(new Store($request, $guide));
        }

        $this->unauthorized();
    }

    /**
     * Displays the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $guide = $this->guide->locate($id, [
            'steps' => function (HasMany $query) {
                $query->orderBy('position');
            },
        ]);

        // Limit the view if the user isn't allowed
        // to view unpublished guides.
        if (!GuidePolicy::viewUnpublished(auth()->user(), $guide)) {
            $this->unauthorized();
        }

        $navbar = $this->presenter->navbarShow($guide);

        $formStep = $this->presenter->formStep($guide);

        return view('pages.resources.guides.show', compact('guide', 'navbar', 'formStep'));
    }

    /**
     * Displays the form for editing the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if (GuidePolicy::edit(auth()->user())) {
            $guide = $this->guide->locate($id);

            $form = $this->presenter->form($guide);

            return view('pages.resources.guides.edit', compact('form'));
        }

        $this->unauthorized();
    }

    /**
     * Updates the specified guide.
     *
     * @param GuideRequest $request
     * @param int|string   $id
     *
     * @return bool
     */
    public function update(GuideRequest $request, $id)
    {
        if (GuidePolicy::edit(auth()->user())) {
            $guide = $this->guide->locate($id);

            return $this->dispatch(new Update($request, $guide));
        }

        $this->unauthorized();
    }

    /**
     * Favorites the specified guide.
     *
     * @param int|string $id
     *
     * @return Guide|bool
     */
    public function favorite($id)
    {
        $guide = $this->guide->locate($id);

        return $this->dispatch(new Favorite($guide));
    }

    /**
     * Deletes the specified model.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        if (GuidePolicy::destroy(auth()->user())) {
            $guide = $this->guide->locate($id);

            return $guide->delete();
        }

        $this->unauthorized();
    }
}
