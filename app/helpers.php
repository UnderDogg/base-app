<?php

use Rhumsaa\Uuid\Uuid;

/**
 * Generates a session flash message
 *
 * @param null|string $title
 * @param null|string $message
 *
 * @return null|\App\Http\Flash
 */
function flash($title = null, $message = null)
{
    $flash = new \App\Http\Flash();

    if(func_num_args() === 0) {
        return $flash;
    }

    $flash->info($title, $message);
}

/**
 * Generates a unique UUID string.
 *
 * @return string
 */
function uuid()
{
    return Uuid::uuid3(Uuid::NAMESPACE_DNS, str_random())->toString();
}

/**
 * Compare given route with current route and return output if they match.
 *
 * @param string $route
 * @param string $output
 *
 * @return string|null
 */
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) {
        return $output;
    }

    return null;
}

