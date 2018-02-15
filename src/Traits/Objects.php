<?php

namespace __\Traits;

trait Objects
{
    /**
     * check if give value is array or not
     *
     * @param null $value
     *
     * @return bool
     *
     */
    public static function isArray($value = null)
    {
        return \is_array($value);
    }

    /**
     * check if give value is function or not
     *
     * @param null $value
     *
     * @return bool
     *
     */
    public static function isFunction($value = null)
    {
        return \is_callable($value);
    }

    /**
     * check if give value is null or not
     *
     * @param null $value
     *
     * @return bool
     *
     */
    public static function isNull($value = null)
    {
        return \is_null($value);
    }


    /**
     * check if give value is number or not
     *
     * @param null $value
     *
     * @return bool
     *
     */
    public static function isNumber($value = null)
    {
        return \is_numeric($value);
    }

    /**
     * check if give value is object or not
     *
     * @param null $value
     *
     * @return bool
     *
     */
    public static function isObject($value = null)
    {
        return \is_object($value);
    }

    /**
     * check if give value is string or not
     *
     * @param null $value
     *
     * @return bool
     *
     */
    public static function isString($value = null)
    {
        return \is_string($value);
    }

    /**
     * Check if the object is a collection.
     * A collection is either an array or an object.
     *
     * @param null $object
     *
     * @return bool
     */
    public static function isCollection($object)
    {
        return \__::isArray($object) || \__::isObject($object);
    }
}