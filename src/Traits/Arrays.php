<?php

namespace __\Traits;

trait Arrays
{
    /**
     * Append item to array
     *
     * @usage __::append([1, 2, 3], 4);
     *        >> [1, 2, 3, 4]
     *
     * @param array $array original array
     * @param mixed $value new item or value to append
     *
     * @return array
     */
    public static function append(array $array = [], $value = null): array
    {
        $array[] = $value;

        return $array;
    }

    /**
     * Creates  an  array  with  all  falsey  values removed. The values false, null, 0, "", undefined, and NaN are all
     * falsey.
     *
     * @usage __::compact([0, 1, false, 2, '', 3]);
     *        >> [1, 2, 3]
     *
     * @param array $array array to compact
     *
     * @return array
     */
    public static function compact(array $array = []): array
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
     * @param bool  $shallow
     * @param bool  $strict
     * @param int   $startIndex
     *
     * @return array
     */
    public static function baseFlatten(
        array $array,
        bool $shallow = false,
        bool $strict = true,
        int $startIndex = 0
    ): array {
        $idx    = 0;
        $output = [];

        foreach ($array as $index => $value) {
            if (is_array($value)) {
                if (!$shallow) {
                    $value = static::baseFlatten($value, $shallow, $strict);
                }
                $j   = 0;
                $len = count($value);
                while ($j < $len) {
                    $output[$idx++] = $value[$j++];
                }
            } else {
                if (!$strict) {
                    $output[$idx++] = $value;
                }
            }
        }

        return $output;
    }

    /**
     * Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.
     *
     * @usage __::flatten([1, 2, [3, [4]]], [flatten]);
     *        >> [1, 2, 3, 4]
     *
     * @param array $array
     * @param bool  $shallow
     *
     * @return array
     */
    public static function flatten(array $array, bool $shallow = false): array
    {
        return static::baseFlatten($array, $shallow, false);
    }

    /**
     *  Patches array by xpath.
     *
     * @usage __::patch(
     *               ['addr' => ['country' => 'US', 'zip' => 12345]],
     *               ['/addr/country' => 'CA','/addr/zip' => 54321]
     *           );
     **       >> ['addr' => ['country' => 'CA', 'zip' => 54321]]
     *
     * @param array  $array   The array to patch
     * @param array  $patches List of new xpath-value pairs
     * @param string $parent
     *
     * @return array Returns patched array
     */
    public static function patch(array $array, array $patches, string $parent = ''): array
    {
        foreach ($array as $key => $value) {
            $z = $parent . '/' . $key;

            if (isset($patches[$z])) {
                $array[$key] = $patches[$z];
                unset($patches[$z]);

                if (!count($patches)) {
                    break;
                }
            }

            if (is_array($value)) {
                $array[$key] = static::patch($value, $patches, $z);
            }
        }

        return $array;
    }

    /**
     * Prepend item or value to an array
     *
     * @usage __::prepend([1, 2, 3], 4);
     *        >> [4, 1, 2, 3]
     *
     * @param array $array
     * @param mixed $value
     *
     * @return array
     */
    public static function prepend(array $array = [], $value = null): array
    {
        array_unshift($array, $value);

        return $array;
    }

    /**
     * Generate range of values based on start , end and step
     *
     * @usage __::range(1, 10, 2);
     **       >> [1, 3, 5, 7, 9]
     *
     * @param int|null $start range start
     * @param int|null $stop  range end
     * @param int      $step  range step value
     *
     * @return array range of values
     */
    public static function range($start = null, $stop = null, int $step = 1): array
    {
        if ($stop == null && $start != null) {
            $stop  = $start;
            $start = 1;
        }

        return range($start, $stop, $step);
    }

    /**
     * Generate array of repeated values
     *
     * @usage __::repeat('foo', 3);
     **       >> ['foo', 'foo', 'foo']
     *
     * @param string $object The object to repeat.
     * @param null   $times  ow many times has to be repeated.
     *
     * @return array Returns a new array of filled values.
     *
     */
    public static function repeat(string $object = '', $times = null): array
    {
        $times = abs($times);
        if ($times == null) {
            return [];
        }

        return array_fill(0, $times, $object);
    }

    /**
     * Creates an array of elements split into groups the length of size. If array can't be split evenly, the final
     * chunk will be the remaining elements.
     *
     * @usage __::chunk([1, 2, 3, 4, 5], 3);
     *        >> [[1, 2, 3], [4, 5]]
     *
     * @param array $array          original array
     * @param int   $size           the chunk size
     * @param bool  $preserveKeys   When set to TRUE keys will be preserved. Default is FALSE which will reindex the
     *                              chunk numerically
     *
     * @return array
     */
    public static function chunk(array $array, int $size = 1, bool $preserveKeys = false): array
    {
        return array_chunk($array, $size, $preserveKeys);
    }

    /**
     * Creates a slice of array with n elements dropped from the beginning.
     *
     * @usage __::drop([0, 1, 3], 2);
     *        >> [3]
     *
     * @param array $input  The array to query.
     * @param int   $number The number of elements to drop.
     *
     * @return array
     */
    public static function drop(array $input, int $number = 1): array
    {
        return array_slice($input, $number);
    }

    /**
     * Shuffle an array ensuring no item remains in the same position.
     *
     * @usage __::randomize([1, 2, 3]);
     *        >> [2, 3, 1]
     *
     * @param array $array original array
     *
     * @return array
     */
    public static function randomize(array $array): array
    {
        for ($i = 0, $c = count($array); $i < $c - 1; $i++) {
            $j = rand($i + 1, $c - 1);
            list($array[$i], $array[$j]) = [$array[$j], $array[$i]];
        }

        return $array;
    }

    /**
     * Search for the index of a value in an array.
     *
     * @usage __::search(['a', 'b', 'c'], 'b')
     *        >> 1
     *
     * @param array  $array
     * @param string $value
     *
     * @return mixed
     */
    public static function search(array $array, string $value)
    {
        return array_search($value, $array, true);
    }
}
