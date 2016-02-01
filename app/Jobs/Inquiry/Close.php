<?php

namespace App\Jobs\Inquiry;

use App\Jobs\Job;
use App\Models\Inquiry;

class Close extends Job
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
     * Closes the current inquiry.
     *
     * @return bool
     */
    public function handle()
    {
        if ($this->inquiry->isOpen()) {
            $this->inquiry->closed = true;

            return $this->inquiry->save();
        }

        return false;
    }
}
