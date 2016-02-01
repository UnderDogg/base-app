<?php

namespace App\Jobs\Inquiry;

use App\Jobs\Job;
use App\Models\Inquiry;

class Open extends Job
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
     * Opens the current inquiry.
     *
     * @return bool
     */
    public function handle()
    {
        if ($this->inquiry->isClosed()) {
            $this->inquiry->closed = false;

            return $this->inquiry->save();
        }

        return false;
    }
}
