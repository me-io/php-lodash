<?php

namespace __\Traits;

trait Arrays
{
    /**
     * Append item to array
     *
     ** __::append([1, 2, 3], 4);
     ** // → [1, 2, 3, 4]
     *
     * @param array $array original array
     * @param null $value new item or valie to append
     *
     * @return array
     *
     */
    public static function append(array $array = [], $value = null)
    {
        $array[] = $value;

        return $array;
    }

    /**
     * Creates  an  array  with  all  falsey  values removed. The values
     * false, null, 0, "", undefined, and NaN are all falsey.
     *
     ** __::compact([0, 1, false, 2, '', 3]);
     ** // → [1, 2, 3]
     *
     * @param array $array array to compact
     *
     * @return array
     *
     */
    public static function compact(array $array = [])
    {
        $result = [];

        foreach ($array as $value) {
            if ($value) {
                $result[] = $value;
            }
        }

        return $result;
    }


    /**
     * base flatten
     *
     * @param array $array
     * @param bool $shallow
     * @param bool $strict
     * @param int $startIndex
     *
     * @return array
     *
     */
    public static function baseFlatten(array $array, $shallow = false, $strict = true, $startIndex = 0)
    {

        $output = [];
        $idx = 0;

        foreach ($array as $index => $value) {
            if (is_array($value)) {

                if (!$shallow) {
                    $value = static::baseFlatten($value, $shallow, $strict);
                }
                $j = 0;
                $len = count($value);
                while ($j < $len) {
                    $output[$idx++] = $value[$j++];
                }
            } else if (!$strict) {
                $output[$idx++] = $value;
            }
        }

        return $output;
    }

    /**
     * Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.
     *
     * __::flatten([1, 2, [3, [4]]], [flatten]);
     *      >> [1, 2, 3, 4]
     *
     * @param      $array
     * @param bool $shallow
     *
     * @return array
     *
     */
    public static function flatten($array, $shallow = false)
    {
        return static::baseFlatten($array, $shallow, false);
    }

    /**
     *  Patches array by xpath.
     *
     ** __::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
     ** // → ['addr' => ['country' => 'CA', 'zip' => 54321]]
     *
     * @param array $arr The array to patch
     * @param  array $patches List of new xpath-value pairs
     * @param string $parent
     *
     * @return array Returns patched array
     *
     */
    public static function patch($arr, $patches, $parent = '')
    {
        foreach ($arr as $key => $value) {
            $z = $parent . '/' . $key;

            if (isset($patches[$z])) {
                $arr[$key] = $patches[$z];
                unset($patches[$z]);

                if (!count($patches)) {
                    break;
                }
            }

            if (is_array($value)) {
                $arr[$key] = static::patch($value, $patches, $z);
            }
        }

        return $arr;
    }

    /**
     * prend item or value to an array
     *
     ** __::prepend([1, 2, 3], 4);
     ** // → [4, 1, 2, 3]
     *
     * @param array $array
     * @param null $value
     *
     * @return array
     *
     */
    public static function prepend(array $array = [], $value = null)
    {
        \array_unshift($array, $value);

        return $array;
    }

    /**
     * generate range of values based on start , end and step
     ** __::range(1, 10, 2);
     ** // → [1, 3, 5, 7, 9]
     *
     * @param integer|null $start range start
     * @param integer|null $stop range end
     * @param integer $step range step value
     *
     * @return array range of values
     *
     */
    public static function range($start = null, $stop = null, $step = 1)
    {
        if ($stop == null && $start != null) {
            $stop = $start;
            $start = 1;
        }

        return \range($start, $stop, $step);
    }

    /**
     * generate array of repeated values
     *
     ** __::repeat('foo', 3);
     ** // → ['foo', 'foo', 'foo']
     *
     * @param string $object The object to repeat.
     * @param null $times ow many times has to be repeated.
     *
     * @return array Returns a new array of filled values.
     *
     */
    public static function repeat($object = '', $times = null)
    {
        if ($times == null) {
            return [];
        } else {
            return \array_fill(0, $times, $object);
        }
    }


}