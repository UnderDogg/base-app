<?php

namespace App\Processors\Resource;

use App\Http\Presenters\Resource\GuidePresenter;
use App\Http\Requests\Resource\GuideRequest;
use App\Jobs\Resource\Guide\Favorite;
use App\Jobs\Resource\Guide\Store;
use App\Jobs\Resource\Guide\Update;
use App\Models\Guide;
use App\Processors\Processor;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
        $this->authorize($this->guide);

        $form = $this->presenter->form($this->guide);

        return view('pages.resources.guides.create', compact('form'));
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
        $this->authorize($this->guide);

        $guide = $this->guide->newInstance();

        return $this->dispatch(new Store($request, $guide));
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
        if (!policy($guide)->viewUnpublished($guide)) {
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
        $guide = $this->guide->locate($id);

        $this->authorize($guide);

        $form = $this->presenter->form($guide);

        return view('pages.resources.guides.edit', compact('form'));
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
        $guide = $this->guide->locate($id);

        $this->authorize($guide);

        return $this->dispatch(new Update($request, $guide));
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
        $guide = $this->guide->locate($id);

        $this->authorize($guide);

        return $guide->delete();
    }
}
