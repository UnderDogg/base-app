<?php

namespace App\Jobs\Inquiry;

use App\Jobs\Job;
use App\Models\Inquiry;

class Approve extends Job
{
    /**
     * @var Inquiry
     */
    protected $inquiry;

    /**
     * Constructor.
     *
     * @param Inquiry $inquiry
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Approves the current inquiry.
     *
     * @return bool
     */
    public function handle()
    {
        if (!$this->inquiry->isApproved()) {
            // Close the inquiry while approving.
            $this->dispatch(new Close($this->inquiry));

            $this->inquiry->approved = true;

            return $this->inquiry->save();
        }

        return false;
    }
}
