<?php

namespace __\Traits;

trait Utilities
{
    /**
     * Check if the value is valid email.
     *
     * @usage __::isEmail('test@test.com');
     *        >> true
     *
     * @param string $value
     *
     * @return bool
     */
    public static function isEmail(string $value = null): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) != false;
    }

    /**
     * Alis to original time() function which return current time.
     *
     * @usage __::now();
     *        >> 1417546029
     *
     * @return mixed
     */
    public static function now()
    {
        $now = time();

        return $now;
    }

    /**
     * Readable wrapper for strpos()
     *
     * @usage __::stringContains('waffle', 'wafflecone');
     *        >> true
     *
     * @param  string $needle   Substring to search for
     * @param  string $haystack String to search within
     * @param  int    $offset   Index of the $haystack we wish to start at
     *
     * @return bool
     */
    public static function stringContains(string $needle, string $haystack, int $offset = 0): bool
    {
        return strpos($haystack, $needle, $offset) !== false ? true : false;
    }

    /**
     * Returns the first argument it receives
     *
     * @usage __::identity('arg1', 'arg2');
     *        >> 'arg1'
     *
     * @return mixed
     */
    public static function identity()
    {
        $args = func_get_args();

        return isset($args[0]) ? $args[0] : null;
    }
}
