<?php

namespace App\Processors;

use Symfony\Component\HttpKernel\Exception\HttpException;
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

    /**
     * Throws an unauthorized exception.
     *
     * @param string|null $error
     *
     * @throws HttpException
     */
    public function unauthorized($error = null)
    {
        throw new HttpException(403, $error);
    }
}
