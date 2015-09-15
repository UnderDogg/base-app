<?php

namespace App\Processors;

use Illuminate\Foundation\Bus\DispatchesJobs;

abstract class Processor
{
    use DispatchesJobs;

    /**
     * Presenter instance.
     *
     * @var object
     */
    protected $presenter;
}
