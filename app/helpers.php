<?php

use Rhumsaa\Uuid\Uuid;

/**
 * Generates a unique UUID string.
 *
 * @return string
 */
function uuid()
{
    return Uuid::uuid4()->toString();
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
