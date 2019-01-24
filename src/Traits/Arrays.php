<?php

namespace __\Traits;

use __;

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
        $idx = 0;
        $output = [];

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
            $stop = $start;
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
     * @param int    $times  ow many times has to be repeated.
     *
     * @return array Returns a new array of filled values.
     *
     */
    public static function repeat($object = '', int $times = null): array
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

    /**
     * Check if an item is in an array.
     *
     * @usage __::contains(['a', 'b', 'c'], 'b')
     *        >> true
     *
     * @param array  $array
     * @param string $value
     *
     * @return bool
     */
    public static function contains(array $array, string $value): bool
    {
        return in_array($value, $array, true);
    }

    /**
     * Returns the average value of an array.
     *
     * @usage __::average([1, 2, 3])
     *        >> 2
     *
     * @param array $array    The source array
     * @param int   $decimals The number of decimals to return
     *
     * @return float The average value
     */
    public static function average(array $array, int $decimals = 0): float
    {
        return round((array_sum($array) / count($array)), $decimals);
    }

    /**
     * Get the size of an array.
     *
     * @usage __::size([1, 2, 3])
     *        >> 3
     *
     * @param array $array
     *
     * @return int
     */
    public static function size(array $array)
    {
        return count($array);
    }

    /**
     * Clean all falsy values from an array.
     *
     * @usage __::clean([true, false, 0, 1, 'string', ''])
     *        >> [true, 1, 'string']
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function clean(array $array)
    {
        return __::filter($array, function ($value) {
            return (bool)$value;
        });
    }

    /**
     * Get a random string from an array.
     *
     * @usage __::random([1, 2, 3])
     *        >> Returns 1, 2 or 3
     *
     * @param array   $array
     * @param integer $take
     *
     * @return mixed
     */
    public static function random(array $array, $take = null)
    {
        if (!$take) {
            return $array[array_rand($array)];
        }
        shuffle($array);

        return __::first($array, $take);
    }


    /**
     * Return an array with all elements found in both input arrays.
     *
     * @usage __::intersection(["green", "red", "blue"], ["green", "yellow", "red"])
     *        >> ["green", "red"]
     *
     * @param array $a
     * @param array $b
     *
     * @return array
     */
    public static function intersection(array $a, array $b): array
    {
        $a = (array)$a;
        $b = (array)$b;

        return array_values(array_intersect($a, $b));
    }

    /**
     * Return a boolean flag which indicates whether the two input arrays have any common elements.
     *
     * @usage __::intersects(["green", "red", "blue"], ["green", "yellow", "red"])
     *        >> true
     *
     * @param array $a
     * @param array $b
     *
     * @return bool
     */
    public static function intersects(array $a, array $b): bool
    {
        $a = (array)$a;
        $b = (array)$b;

        return count(self::intersection($a, $b)) > 0;
    }

    /**
     * Exclude the last X elements from an array
     *
     * @usage __::initial([1, 2, 3], 1);
     *        >> [1, 2]
     *
     * @param array $array
     * @param int   $to
     *
     * @return mixed
     */
    public static function initial(array $array, int $to = 1)
    {
        $slice = count($array) - $to;

        return __::first($array, $slice);
    }

    /**
     * Exclude the first X elements from an array
     *
     * @usage __::rest([1, 2, 3], 2);
     *        >> [3]
     *
     * @param array $array
     * @param int   $from
     *
     * @return array
     */
    public static function rest(array $array, int $from = 1): array
    {
        return array_splice($array, $from);
    }

    /**
     * Sort an array by key.
     *
     * @usage __::sortKeys(['z' => 0, 'b' => 1, 'r' => 2])
     *        >> ['b' => 1, 'r' => 2, 'z' => 0]
     *
     * @param array  $array
     * @param string $direction
     *
     * @return mixed
     */
    public static function sortKeys(array $array, string $direction = 'ASC')
    {
        $direction = (strtolower($direction) === 'desc') ? SORT_DESC : SORT_ASC;
        if ($direction === SORT_ASC) {
            ksort($array);
        } else {
            krsort($array);
        }

        return $array;
    }

    /**
     * Remove unwanted values from array
     *
     * @param array        $array
     * @param array|string $remove
     * @param bool         $preserveKeys , set true if you want to preserve the keys. by default false
     *
     * @usage _::without([1,5=>3,2 => 4,5],2)
     *
     * @return array
     */
    public static function without(array $array, $remove, $preserveKeys = false): array
    {
        $remove = !is_array($remove) ? [$remove] : $remove;
        $result = [];
        foreach ($array as $key => $value) {
            if (in_array($value, $remove)) {
                continue;
            }

            if ($preserveKeys) {
                $result[$key] = $value;
            } else {
                $result[] = $value;
            }
        }

        return $result;
    }
}
