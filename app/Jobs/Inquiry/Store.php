<?php

namespace App\Jobs\Inquiry;

use App\Http\Requests\Inquiry\InquiryRequest;
use App\Jobs\Job;
use App\Models\Category;
use App\Models\Inquiry;

class Store extends Job
{
    /**
     * @var InquiryRequest
     */
    protected $request;

    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * @var Category
     */
    protected $category;

    /**
     * Constructor.
     *
     * @param InquiryRequest $request
     * @param Inquiry        $inquiry
     * @param Category       $category
     */
    public function __construct(InquiryRequest $request, Inquiry $inquiry, Category $category)
    {
        $this->request = $request;
        $this->inquiry = $inquiry;
        $this->category = $category;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->inquiry->user_id = auth()->id();
        $this->inquiry->category_id = $this->category->getKey();
        $this->inquiry->title = $this->request->input('title');
        $this->inquiry->description = $this->request->input('description');

        if ($this->category->manager === true) {
            $this->inquiry->manager_id = $this->request->input('manager');
        }

        return $this->inquiry->save();
    }
}
