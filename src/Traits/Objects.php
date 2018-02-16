<?php

namespace __\Traits;

use __;

trait Objects
{
    /**
     * Check if give value is array or not.
     *
     * __::isArray([1, 2, 3]);
     * // >> true
     *
     * @param null $value
     *
     * @return bool
     */
    public static function isArray($value = null): bool
    {
        return is_array($value);
    }

    /**
     * Check if give value is function or not.
     *
     * __::isFunction(function ($a) { return $a + 2; });
     * // >> true
     *
     * @param null $value
     *
     * @return bool
     */
    public static function isFunction($value = null): bool
    {
        return is_callable($value);
    }

    /**
     * Check if give value is null or not.
     *
     * __::isNull(null);
     * // >> true
     *
     * @param null $value
     *
     * @return bool
     */
    public static function isNull($value = null): bool
    {
        return is_null($value);
    }


    /**
     * Check if give value is number or not.
     *
     * __::isNumber(123);
     * // >> true
     *
     * @param null $value
     *
     * @return bool
     */
    public static function isNumber($value = null): bool
    {
        return is_numeric($value);
    }

    /**
     * Check if give value is object or not.
     *
     * __::isObject('fred');
     * // >> false
     *
     * @param null $value
     *
     * @return bool
     */
    public static function isObject($value = null): bool
    {
        return is_object($value);
    }

    /**
     * Check if give value is string or not.
     *
     * __::isString('fred');
     * // >> true
     *
     * @param null $value
     *
     * @return bool
     */
    public static function isString($value = null): bool
    {
        return is_string($value);
    }

    /**
     * Check if the object is a collection. A collection is either an array or an object.
     *
     * @param null $object
     *
     * @return bool
     */
    public static function isCollection($object): bool
    {
        return __::isArray($object) || __::isObject($object);
    }
}