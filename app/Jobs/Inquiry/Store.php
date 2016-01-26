<?php

namespace App\Jobs\Inquiry;

use App\Http\Requests\Inquiry\InquiryRequest;
use App\Jobs\Job;
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
     * Constructor.
     *
     * @param InquiryRequest $request
     * @param Inquiry        $inquiry
     */
    public function __construct(InquiryRequest $request, Inquiry $inquiry)
    {
        $this->request = $request;
        $this->inquiry = $inquiry;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->inquiry->user_id = auth()->id();
        $this->inquiry->category_id = $this->request->input('category');
        $this->inquiry->title = $this->request->input('title');
        $this->inquiry->description = $this->request->input('description');

        return $this->inquiry->save();
    }
}