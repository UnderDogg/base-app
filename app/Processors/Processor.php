<?php

namespace App\Processors;

use App\Models\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Orchestra\Support\Facades\ACL;

abstract class Processor
{
    use DispatchesJobs;

    use AuthorizesRequests {
        authorize as gateAuthorize;
    }

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
