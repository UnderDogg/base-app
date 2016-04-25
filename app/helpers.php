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
