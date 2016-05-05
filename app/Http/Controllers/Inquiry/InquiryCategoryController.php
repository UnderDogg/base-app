<?php

namespace App\Http\Controllers\Inquiry;

use App\Http\Controllers\Controller;
use App\Http\Presenters\Inquiry\InquiryCategoryPresenter;
use App\Http\Requests\Category\CategoryRequest;
use App\Jobs\Inquiry\Category\Store;
use App\Jobs\Inquiry\Category\Update;
use App\Models\Category;
use App\Models\Inquiry;

class InquiryCategoryController extends Controller
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * @var InquiryCategoryPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Category                 $category
     * @param Inquiry                  $inquiry
     * @param InquiryCategoryPresenter $presenter
     */
    public function __construct(Category $category, Inquiry $inquiry, InquiryCategoryPresenter $presenter)
    {
        $this->category = $category;
        $this->inquiry = $inquiry;
        $this->presenter = $presenter;
    }

    /**
     * Displays all inquiry categories.
     *
     * @param int|string|null $id
     *
     * @return \Illuminate\View\View
     */
    public function index($id = null)
    {
        $this->authorize('categories.index');

        ($id ? $category = $this->category->findOrFail($id) : $category = $this->category);

        $categories = $this->presenter->table($category, $this->inquiry);

        $navbar = $this->presenter->navbar($category);

        return view('pages.categories.index', compact('category', 'categories', 'navbar'));
    }

    /**
     * Displays the form for creating a category.
     *
     * @param int|string|null $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id = null)
    {
        $this->authorize('categories.create');

        ($id ? $parent = $this->category->findOrFail($id) : $parent = null);

        $form = $this->presenter->form($this->category, $parent);

        return view('pages.categories.create', compact('form', 'category'));
    }

    /**
     * Creates a new inquiry category.
     *
     * @param CategoryRequest $request
     * @param int|string|null $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request, $id = null)
    {
        $this->authorize('categories.create');

        $category = $this->category->newInstance();

        $job = new Store($request, $category);

        if ($id) {
            $parent = $this->category->findOrFail($id);

            $job->setParent($parent);
        }

        if ($this->dispatch($job)) {
            flash()->success('Success!', 'Successfully created category.');

            if (is_null($id)) {
                return redirect()->route('inquiries.categories.index');
            }

            return redirect()->route('inquiries.categories.show', [$id]);
        }

        flash()->error('Error!', 'There was an issue creating a category. Please try again.');

        return redirect()->route('inquiries.categories.index');
    }

    /**
     * Displays the form for editing the specified category.
     *
     * @param int|string $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $this->authorize('categories.edit');

        $category = $this->category->findOrFail($id);

        $parent = $category->parent()->first();

        $form = $this->presenter->form($category, $parent);

        return view('pages.categories.edit', compact('form'));
    }

    /**
     * Updates the specified category.
     *
     * @param CategoryRequest $request
     * @param int|string      $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, $id)
    {
        $this->authorize('categories.edit');

        $category = $this->category->findOrFail($id);

        try {
            if ($this->dispatch(new Update($request, $category))) {
                flash()->success('Success!', 'Successfully updated category.');

                return redirect()->route('inquiries.categories.index', [$id]);
            }

            flash()->error('Error!', 'There was an issue updating this category. Please try again.');

            return redirect()->route('inquiries.categories.edit', [$id]);
        } catch (\LogicException $e) {
            flash()->setTimer(null)->error('Error!', "A category can't be a descendant of itself.");

            return redirect()->route('inquiries.categories.edit', [$id]);
        }
    }

    /**
     * Deletes the specified category.
     *
     * @param int|string $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->authorize('categories.destroy');

        $category = $this->category->findOrFail($id);

        if ($category->delete()) {
            flash()->success('Success!', 'Successfully deleted category.');

            return redirect()->route('inquiries.categories.index');
        }

        flash()->error('Error!', 'There was an issue deleting this category. Please try again.');

        return redirect()->route('inquiries.categories.index');
    }
}
