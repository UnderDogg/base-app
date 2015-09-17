<?php

namespace App\Processors;

use App\Models\Label;
use App\Models\Issue;

class IssueLabelProcessor extends Processor
{
    /**
     * Constructor.
     *
     * @param Issue $issue
     * @param Label $label
     */
    public function __construct(Issue $issue, Label $label)
    {
        $this->issue = $issue;
        $this->label = $label;
    }

    public function update()
    {
        //
    }
}
