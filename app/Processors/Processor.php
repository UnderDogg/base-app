<?php

namespace App\Processors;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;

abstract class Processor
{
    use DispatchesJobs, AuthorizesRequests;

    /**
     * Presenter instance.
     *
     * @var object
     */
    protected $presenter;
}
