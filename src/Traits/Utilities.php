<?php

namespace __\Traits;

trait Utilities
{
    /**
     * @utilities @isEmail
     * check if the value is valid email
     *
     * @param string $value
     *
     * @return bool
     *
     */
    public static function isEmail($value = null)
    {
        return \filter_var($value, FILTER_VALIDATE_EMAIL) != false;
    }

    /**
     * alis to original time() function which return current time
     *
     * @return mixed
     *
     */
    public static function now()
    {
        $now = time();

        return $now;
    }

    /**
     * Readable wrapper for strpos()
     *
     * @param  string  $needle   Substring to search for
     * @param  string  $haystack String to search within
     * @param  integer $offset   Index of the $haystack we wish to start at
     *
     * @return bool              whether the
     */
    public static function stringContains($needle, $haystack, $offset = 0)
    {
        return strpos($haystack, $needle, $offset) !== false ? true : false;
    }

    /**
     * Returns the first argument it receives
     *
     * __::identity('arg1', 'arg2');
     *      >> 'arg1'
     *
     * @return mixed
     */
    public static function identity()
    {
        $args = func_get_args();

        return isset($args[0]) ? $args[0] : null;
    }
}
