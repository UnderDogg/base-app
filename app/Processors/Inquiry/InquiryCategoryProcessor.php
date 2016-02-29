<?php

namespace App\Processors\Inquiry;

use App\Http\Presenters\Inquiry\InquiryCategoryPresenter;
use App\Http\Requests\Category\CategoryMoveRequest;
use App\Http\Requests\Category\CategoryRequest;
use App\Jobs\Inquiry\Category\Store;
use App\Jobs\Inquiry\Category\Update;
use App\Models\Category;
use App\Processors\Processor;

class InquiryCategoryProcessor extends Processor
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * @var InquiryCategoryPresenter
     */
    protected $presenter;

    /**
     * Constructor.
     *
     * @param Category                 $category
     * @param InquiryCategoryPresenter $presenter
     */
    public function __construct(Category $category, InquiryCategoryPresenter $presenter)
    {
        $this->category = $category;
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
        if ($id) {
            $category = $this->category->findOrFail($id);
        } else {
            $category = $this->category;
        }

        $categories = $this->presenter->table($category);

        $navbar = $this->presenter->navbar($category);

        return view('pages.categories.index', compact('category', 'categories', 'navbar'));
    }

    /**
     * Displays the form for creating a new category.
     *
     * @param int|string|null $id
     *
     * @return \Illuminate\View\View
     */
    public function create($id = null)
    {
        if ($id) {
            $category = $this->category->findOrFail($id);

            $form = $this->presenter->form($this->category, $category);
        } else {
            $form = $this->presenter->form($this->category);
        }

        return view('pages.categories.create', compact('form', 'category'));
    }

    /**
     * Creates a new category.
     *
     * @param CategoryRequest $request
     * @param int|string|null $id
     *
     * @return bool
     */
    public function store(CategoryRequest $request, $id = null)
    {
        $category = $this->category->newInstance();

        $job = new Store($request, $category);

        if ($id) {
            $parent = $this->category->findOrFail($id);

            $job->setParent($parent);
        }

        return $this->dispatch($job);
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
        $category = $this->category->findOrFail($id);

        $form = $this->presenter->form($category);

        return view('pages.categories.edit', compact('form'));
    }

    /**
     * Updates the specified inquiry category.
     *
     * @param CategoryRequest $request
     * @param int|string      $id
     *
     * @return bool
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->category->findOrFail($id);

        return $this->dispatch(new Update($request, $category));
    }

    /**
     * Moves the specified category.
     *
     * @param CategoryMoveRequest $request
     * @param int|string          $id
     *
     * @return bool
     */
    public function move(CategoryMoveRequest $request, $id)
    {
        $category = $this->category->findOrFail($id);

        $parent = $this->category->findOrFail($request->input('parent_id'));

        return $category->makeChildOf($parent);
    }

    /**
     * Deletes the specified category.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        $category = $this->category->findOrFail($id);

        $category->destroyDescendants();

        return $category->delete();
    }

    /**
     * Returns true / false if the specified category requires a manager.
     *
     * @param int|string $id
     *
     * @return bool
     */
    public function manager($id)
    {
        $category = $this->category->findOrFail($id);

        return json_encode($category->manager);
    }
}
