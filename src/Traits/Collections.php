<?php

namespace __\Traits;

trait Collections
{
    /**
     * Returns the values in the collection that pass the truth test.
     *
     * @param array $array array to filter
     * @param \Closure $closure closure to filter array based on
     *
     * @return array
     *
     */
    public static function filter(array $array = [], \Closure $closure)
    {
        if (!$closure) {
            return \__::compact($array);
        } else {
            $result = [];

            foreach ($array as $key => $value) {
                if (\call_user_func($closure, $value)) {
                    $result[] = $value;
                }
            }

            return $result;
        }
    }

    /**
     * Gets the first element of an array. Passing n returns the first n elements.
     *
     * @param array $array of values
     * @param null $take number of values to return
     *
     * @return array|mixed
     *
     */
    public static function first($array, $take = null)
    {
        if (!$take) {
            return \array_shift($array);
        }

        return \array_splice($array, 0, $take, true);
    }

    /**
     * get item of an array by index , aceepting nested index
     *
     ** __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
     ** // → 'ter'
     *
     * @param array $collection array of values
     * @param string $key key or index
     * @param null $default default value to return if index not exist
     *
     * @return array|mixed|null
     *
     */
    public static function get($collection = [], $key = '', $default = null)
    {
        if (\__::isNull($key)) {
            return $collection;
        }

        if (!\__::isObject($collection) && isset($collection[$key])) {
            return $collection[$key];
        }

        foreach (\explode('.', $key) as $segment) {
            if (\__::isObject($collection)) {
                if (!isset($collection->{$segment})) {
                    return $default instanceof \Closure ? $default() : $default;
                } else {
                    $collection = $collection->{$segment};
                }
            } else {
                if (!isset($collection[$segment])) {
                    return $default instanceof \Closure ? $default() : $default;
                } else {
                    $collection = $collection[$segment];
                }
            }
        }

        return $collection;
    }

    /**
     * get last item(s) of an array
     *
     * @param array $array array of values
     * @param null $take number of returned values
     *
     * @return array|mixed
     *
     */
    public static function last($array, $take = null)
    {
        if (!$take) {
            return \array_pop($array);
        }

        return \array_splice($array, -$take);
    }

    /**
     * Returns an array of values by mapping each in collection through the iterator.
     *
     * @param array $array array of values
     * @param \Closure $closure closure to mapp based on
     *
     * @return array
     *
     */
    public static function map(array $array = [], \Closure $closure)
    {
        foreach ($array as $key => $value) {
            $array[$key] = $closure($value, $key);
        }

        return $array;
    }

    /**
     * Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the
     * iterator.
     *
     * @param array $array array
     *
     * @return mixed maximum value
     *
     */
    public static function max(array $array = [])
    {
        return \max($array);
    }

    /**
     * Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the
     * iterator.
     *
     * @param array $array array of values
     *
     * @return mixed
     *
     */
    public static function min(array $array = [])
    {
        return \min($array);
    }

    /**
     * Returns an array of values belonging to a given property of each item in a collection.
     *
     * @param array $collection rray
     * @param string $property property
     *
     * @return array|object
     *
     */
    public static function pluck($collection = [], $property = '')
    {
        $plucked = \array_map(
            function ($value) use ($property) {
                return \__::get($value, $property);
            }, (array)$collection
        );

        if (\__::isObject($collection)) {
            $plucked = (object)$plucked;
        }

        return $plucked;
    }


    /**
     * return data matching specific key value condition
     *
     **_::where($a, ['age' => 16]);
     ** // >> [['name' => 'maciej', 'age' => 16]]
     *
     * @param array $array array of values
     * @param array $key condition in format of ['KEY'=>'VALUE']
     * @param bool $keepKeys keep original keys
     *
     * @return array
     *
     */
    public static function where(array $array = [], array $key = [], $keepKeys = false)
    {
        $result = [];

        foreach ($array as $k => $v) {
            $not = false;

            foreach ($key as $j => $w) {
                if (\__::isArray($w)) {
                    if (count(array_intersect($w, $v[$j])) == 0) {
                        $not = true;
                        break;
                    }
                } else {
                    if (!isset($v[$j]) || $v[$j] != $w) {
                        $not = true;
                        break;
                    }
                }
            }

            if ($not == false) {
                if ($keepKeys) {
                    $result[$k] = $v;
                } else {
                    $result[] = $v;
                }
            }
        }

        return $result;
    }

}