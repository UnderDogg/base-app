<?php

namespace App\Http\Requests;

use Stevebauman\Purify\Facades\Purify;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Purifies the specified HTML input.
     *
     * @param string|array $input
     *
     * @return string
     */
    public function clean($input)
    {
        return Purify::clean($input);
    }

    /**
     * Validate the input.
     *
     * @param  \Illuminate\Validation\Factory  $factory
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator($factory)
    {
        return $factory->make(
            $this->sanitizeInput(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    /**
     * Sanitize the input.
     *
     * @return array
     */
    protected function sanitizeInput()
    {
        if (method_exists($this, 'sanitize'))
        {
            return $this->container->call([$this, 'sanitize']);
        }

        return $this->all();
    }
}
