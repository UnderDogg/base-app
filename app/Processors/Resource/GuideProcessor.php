<?php

namespace App\Processors\Resource;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Http\Presenters\Resource\GuidePresenter;
use App\Http\Requests\Resource\GuideRequest;
use App\Models\Guide;
use App\Processors\Processor;

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
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $guides = $this->presenter->table($this->guide);

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
        $guide = $this->guide->newInstance();

        $guide->slug = Str::slug($request->input('title'));
        $guide->title = $request->input('title');
        $guide->description = $request->input('description');

        $published = $request->has('publish');

        if ($published) {
            $guide->published = true;
            $guide->published_on = $guide->freshTimestampString();
        }

        return $guide->save();
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
            }
        ]);

        return view('pages.resources.guides.show', compact('guide'));
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

        $guide->slug = Str::slug($request->input('title'));
        $guide->title = $request->input('title');
        $guide->description = $request->input('description');

        $published = $request->has('publish');

        if ($published) {
            $guide->published = true;
            $guide->published_on = $guide->freshTimestampString();
        } else {
            $guide->published = false;
            $guide->published_on = null;
        }

        return $guide->save();
    }

    /**
     * Deletes the specified model
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $guide = $this->guide->locate($id);

        return $guide->delete();
    }
}