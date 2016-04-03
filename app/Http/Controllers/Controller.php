<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class Controller extends BaseController
{
    use ValidatesRequests, AuthorizesRequests, DispatchesJobs;

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
