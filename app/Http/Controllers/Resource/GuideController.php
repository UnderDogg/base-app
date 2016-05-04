<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Resource\GuidePresenter;
use App\Http\Requests\Resource\GuideRequest;
use App\Jobs\Resource\Guide\Favorite;
use App\Jobs\Resource\Guide\Store;
use App\Jobs\Resource\Guide\Update;
use App\Models\Guide;
use App\Policies\Resource\GuidePolicy;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class GuideController extends Controller
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
     * Displays all guides.
     *
     * @param bool $favorites
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
     * Displays all favorited guides.
     *
     * @return \Illuminate\View\View
     */
    public function favorites()
    {
        return $this->index($favorites = true);
    }

    /**
     * Displays the form for creating a new guide.
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
     * Store a newly created resource in storage.
     *
     * @param GuideRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GuideRequest $request)
    {
        $this->authorize($this->guide);

        $guide = $this->guide->newInstance();

        if ($this->dispatch(new Store($request, $guide))) {
            flash()->success('Success!', 'Successfully created guide!');

            return redirect()->route('resources.guides.index');
        }

        flash()->error('Error!', 'There was an issue creating a guide. Please try again.');

        return redirect()->route('resources.guides.create');
    }

    /**
     * Display the specified resource.
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
        if (!policy($guide)->viewUnpublished(Auth::user(), $guide)) {
            $this->unauthorized();
        }

        $navbar = $this->presenter->navbarShow($guide);

        $formStep = $this->presenter->formStep($guide);

        return view('pages.resources.guides.show', compact('guide', 'navbar', 'formStep'));
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
        $guide = $this->guide->locate($id);

        $this->authorize($guide);

        $form = $this->presenter->form($guide);

        return view('pages.resources.guides.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param GuideRequest $request
     * @param int|string   $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(GuideRequest $request, $id)
    {
        $guide = $this->guide->locate($id);

        $this->authorize($guide);

        if ($this->dispatch(new Update($request, $guide))) {
            flash()->success('Success!', 'Successfully updated guide!');

            return redirect()->route('resources.guides.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue updating this guide. Please try again.');

        return redirect()->route('resources.guides.edit', [$id]);
    }

    /**
     * Favorites the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function favorite($id)
    {
        $guide = $this->guide->locate($id);

        if ($this->dispatch(new Favorite($guide))) {
            return redirect()->route('resources.guides.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue with adding this guide to your favorites. Please try again.');

        return redirect()->route('resources.guides.show', [$id]);
    }

    /**
     * Deletes the specified guide.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $guide = $this->guide->locate($id);

        $this->authorize($guide);

        if ($guide->delete()) {
            flash()->success('Success!', 'Successfully deleted guide!');

            return redirect()->route('resources.guides.index');
        }

        flash()->error('Error!', 'There was an issue deleting this guide. Please try again.');

        return redirect()->route('resources.guides.show', [$id]);
    }
}
