<?php

namespace App\Jobs\Inquiry\Category;

use App\Http\Requests\Category\CategoryRequest;
use App\Models\Category;
use App\Jobs\Job;

class Store extends Job
{
    /**
     * @var CategoryRequest
     */
    protected $request;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var Category|null
     */
    protected $parent;

    /**
     * Constructor.
     *
     * @param CategoryRequest        $request
     * @param Category               $category
     * @param Category|null          $parent
     */
    public function __construct(CategoryRequest $request, Category $category, Category $parent = null)
    {
        $this->request = $request;
        $this->category = $category;
        $this->parent = $parent;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->category->name = $this->request->input('name');
        $this->category->belongs_to = 'inquiries';

        if ($this->request->has('parent')) {
            $this->category->parent_id = $this->request->input('parent');
        }

        if ($this->category->save()) {
            if ($this->parent instanceof Category) {
                $this->category->makeChildOf($this->parent);
            }

            return true;
        }

        return false;
    }

    /**
     * Sets the categories new parent.
     *
     * @param Category $parent
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }
}
