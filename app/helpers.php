<?php

use App\Http\Active;
use App\Http\Flash;
use Rhumsaa\Uuid\Uuid;

/**
 * Generates a session flash message.
 *
 * @param null|string $title
 * @param null|string $message
 *
 * @return null|Flash
 */
function flash($title = null, $message = null)
{
    $flash = new Flash();

    if (func_num_args() === 0) {
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
 * Generates a new Active instance.
 *
 * @return Active
 */
function active()
{
    return new Active();
}

/**
 * Validates that the inserted string is an object SID.
 *
 * @param string $sid
 *
 * @return bool
 */
function isValidSid($sid)
{
    preg_match("/S-1-5-21-\d+-\d+\-\d+\-\d+/", $sid, $matches);

    if (count($matches) > 0) {
        return true;
    }

    return false;
}
