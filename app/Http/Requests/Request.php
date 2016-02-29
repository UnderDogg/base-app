<?php

namespace App\Http\Requests;

use App\Traits\CanPurifyTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    use CanPurifyTrait;

    /**
     * Validate the input.
     *
     * @param \Illuminate\Validation\Factory $factory
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
        if (method_exists($this, 'sanitize')) {
            return $this->container->call([$this, 'sanitize']);
        }

        return $this->all();
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        $errors = $validator->getMessageBag()->toArray();

        foreach ($errors as $key => $error) {
            // If the error key contains a period, the field can have multiple values.
            // We need to format the errors for orchestra form compatibility.
            if (str_contains($key, '.')) {
                $newKey = explode('.', $key)[0];

                // Assign the new error key.
                $errors[$newKey] = $errors[$key];

                unset($errors[$key]);
            }
        }

        return $errors;
    }
}
