<?php

namespace App\Jobs\Inquiry\Category;

use App\Http\Requests\Category\CategoryRequest;
use App\Jobs\Job;
use App\Models\Category;

class Update extends Job
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
     * Constructor.
     *
     * @param CategoryRequest $request
     * @param Category        $category
     */
    public function __construct(CategoryRequest $request, Category $category)
    {
        $this->request = $request;
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->category->name = $this->request->input('name');

        $this->category->options = [
            'manager' => $this->request->has('manager'),
        ];

        $this->category->parent_id = $this->request->parent;

        return $this->category->save();
    }
}
