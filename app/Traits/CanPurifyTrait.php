<?php

namespace App\Traits;

use Stevebauman\Purify\Facades\Purify;

trait CanPurifyTrait
{
    /**
     * Cleans the specified HTML input.
     *
     * @param string|array $input
     * @param array        $options
     *
     * @return mixed
     */
    protected function clean($input, array $options = [])
    {
        return Purify::clean($input, $options);
    }
}
