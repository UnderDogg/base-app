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
     * @param Inquiry $inquiry
     */
    public function __construct(InquiryRequest $request, Inquiry $inquiry)
    {
        $this->request = $request;
        $this->inquiry = $inquiry;
    }

    public function handle()
    {
        //
    }
}
