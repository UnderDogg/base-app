<?php

/**
 * Generates a unique UUID string.
 *
 * @return string
 */
function uuid()
{
    return \Faker\Provider\Uuid::uuid();
}
