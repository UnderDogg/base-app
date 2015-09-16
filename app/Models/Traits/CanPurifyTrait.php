<?php

namespace App\Models\Traits;

use Stevebauman\Purify\Facades\Purify;

trait CanPurifyTrait
{
    /**
     * Cleans the specified HTML input.
     *
     * @param string|array $input
     *
     * @return mixed
     */
    protected function clean($input)
    {
        return Purify::clean($input);
    }
}
