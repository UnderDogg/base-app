<?php

namespace App\Jobs\Inquiry;

use App\Jobs\Job;
use App\Models\Inquiry;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Approve extends Job
{
    use DispatchesJobs;

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
