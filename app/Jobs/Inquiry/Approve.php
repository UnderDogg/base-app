<?php

namespace App\Jobs\Inquiry;

use App\Exceptions\Inquiry\AlreadyApprovedException;
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
     * @throws AlreadyApprovedException
     *
     * @return bool
     */
    public function handle()
    {
        if (!$this->inquiry->isApproved()) {
            // Close the inquiry while approving.
            $this->dispatch(new Close($this->inquiry));

            // Set the inquiry to approved.
            $this->inquiry->approved = true;

            // Reset the inquiries UUID.
            $this->inquiry->uuid = null;

            // Save the inquiry.
            return $this->inquiry->save();
        }

        throw new AlreadyApprovedException('This request has already been approved.');
    }
}
