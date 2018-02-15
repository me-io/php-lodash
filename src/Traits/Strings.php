<?php

namespace __\Traits;

trait Strings
{
    /**
     * Split a string by string.
     *
     * Based on explode, see http://php.net/manual/en/function.explode.php.
     *
     * __::split('a-b-c', '-', 2);
     *      >> ['a', 'b-c']
     *
     * @param string $input     The string to split.
     * @param string $delimiter The boundary string.
     * @param int    $limit     (optional) If limit is set and positive, the returned array
     *                          will contain a maximum of limit elements with the last element containing the
     *                          rest of string.
     *                          If the limit parameter is negative, all components except the last -limit are returned.
     *                          If the limit parameter is zero, then this is treated as 1.
     *
     * @return string
     */
    public static function split($input, $delimiter, $limit = PHP_INT_MAX)
    {
        return explode($delimiter, $input, $limit);
    }
}