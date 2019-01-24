<?php

namespace __\Traits;

use __;
use Closure;
use Exception;
use stdClass;

trait Collections
{
    /**
     * Returns the values in the collection that pass the truth test.
     *
     * @param array    $array   array to filter
     * @param \Closure $closure closure to filter array based on
     *
     * @return array
     */
    public static function filter(array $array = [], Closure $closure = null): array
    {
        if ($closure) {
            $result = [];

            foreach ($array as $key => $value) {
                if (call_user_func($closure, $value)) {
                    $result[] = $value;
                }
            }

            return $result;
        }

        return __::compact($array);
    }

    /**
     * Gets the first element of an array. Passing n returns the first n elements.
     *
     * @usage __::first([1, 2, 3]);
     *        >> 1
     *
     * @param array    $array of values
     * @param int|null $take  number of values to return
     *
     * @return mixed
     */
    public static function first(array $array, $take = null)
    {
        if (!$take) {
            return array_shift($array);
        }

        return array_splice($array, 0, $take);
    }

    /**
     * Get item of an array by index, accepting nested index
     *
     * @usage __::get(['foo' => ['bar' => 'ter']], 'foo.bar');
     *        >> 'ter'
     *
     * @param array|object $collection array of values
     * @param null|string  $key        key or index
     * @param mixed        $default    default value to return if index not exist
     *
     * @return mixed
     */
    public static function get($collection = [], $key = null, $default = null)
    {
        if (__::isNull($key)) {
            return $collection;
        }

        if (!__::isObject($collection) && isset($collection[$key])) {
            return $collection[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (__::isObject($collection)) {
                if (!isset($collection->{$segment})) {
                    return $default instanceof Closure ? $default() : $default;
                } else {
                    $collection = $collection->{$segment};
                }
            } else {
                if (!isset($collection[$segment])) {
                    return $default instanceof Closure ? $default() : $default;
                } else {
                    $collection = $collection[$segment];
                }
            }
        }

        return $collection;
    }

    /**
     * Get last item(s) of an array
     *
     * @usage __::last([1, 2, 3, 4, 5], 2);
     *        >> [4, 5]
     *
     * @param array    $array array of values
     * @param int|null $take  number of returned values
     *
     * @return mixed
     */
    public static function last(array $array, $take = null)
    {
        if (!$take) {
            return array_pop($array);
        }

        return array_splice($array, -$take);
    }

    /**
     * Returns an array of values by mapping each in collection through the iterateFn. The iterateFn is invoked with
     * three arguments: (value, index|key, collection).
     *
     * @usage __::map([1, 2, 3], function($n) {
     *               return $n * 3;
     *           });
     *       >> [3, 6, 9]
     *
     * @param array|object $collection The collection of values to map over.
     * @param \Closure     $iterateFn  The function to apply on each value.
     *
     * @return array
     */
    public static function map($collection, Closure $iterateFn): array
    {
        $result = [];

        __::doForEach($collection, function ($value, $key, $collection) use (&$result, $iterateFn) {
            $result[] = $iterateFn($value, $key, $collection);
        });

        return $result;
    }

    /**
     * Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the
     * iterator.
     *
     * @usage __::max([1, 2, 3]);
     *        >> 3
     *
     * @param array $array The array to iterate over
     *
     * @return mixed Returns the maximum value
     */
    public static function max(array $array = [])
    {
        return max($array);
    }

    /**
     * Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the
     * iterator.
     *
     * @usage __::min([1, 2, 3]);
     *        >> 1
     *
     * @param array $array array of values
     *
     * @return mixed
     */
    public static function min(array $array = [])
    {
        return min($array);
    }

    /**
     * Returns an array of values belonging to a given property of each item in a collection.
     *
     * @usage $a = [
     *            ['foo' => 'bar',  'bis' => 'ter' ],
     *            ['foo' => 'bar2', 'bis' => 'ter2'],
     *        ];
     *
     *        __::pluck($a, 'foo');
     *        >> ['bar', 'bar2']
     *
     * @param array|object $collection array or object that can be converted to array
     * @param string       $property   property name
     *
     * @return array
     */
    public static function pluck($collection, string $property): array
    {
        $result = array_map(function ($value) use ($property) {
            if (is_array($value) && isset($value[$property])) {
                return $value[$property];
            } elseif (is_object($value) && isset($value->{$property})) {
                return $value->{$property};
            }
            foreach (__::split($property, '.') as $segment) {
                if (is_object($value)) {
                    if (isset($value->{$segment})) {
                        $value = $value->{$segment};
                    } else {
                        return null;
                    }
                } else {
                    if (isset($value[$segment])) {
                        $value = $value[$segment];
                    } else {
                        return null;
                    }
                }
            }

            return $value;
        }, (array)$collection);

        return array_values($result);
    }


    /**
     * Return data matching specific key value condition
     *
     * @usage __::where($a, ['age' => 16]);
     *        >> [['name' => 'maciej', 'age' => 16]]
     *
     * @param array $array    array of values
     * @param array $key      condition in format of ['KEY'=>'VALUE']
     * @param bool  $keepKeys keep original keys
     *
     * @return array
     */
    public static function where(array $array = [], array $key = [], bool $keepKeys = false): array
    {
        $result = [];

        foreach ($array as $k => $v) {
            $not = false;

            foreach ($key as $j => $w) {
                if (__::isArray($w)) {
                    $inKV = $v[$j] ?? [];
                    if (count(array_intersect_assoc($w, $inKV)) == 0) {
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

    /**
     * Combines and merge collections provided with each others.
     *
     * If the collections have common keys, then the last passed keys override the
     * previous. If numerical indexes are passed, then last passed indexes override
     * the previous.
     *
     * For a recursive merge, see __::merge.
     *
     * @usage __::assign(['color' => ['favorite' => 'red', 5], 3], [10, 'color' => ['favorite' => 'green', 'blue']]);
     *        >> ['color' => ['favorite' => 'green', 'blue'], 10]
     *
     * @param array|object $collection1 Collection to assign to.
     * @param array|object $collection2 Other collections to assign
     *
     * @return array|object Assigned collection.
     */
    public static function assign($collection1, $collection2)
    {
        return __::reduceRight(func_get_args(), function ($source, $result) {
            __::doForEach($source, function ($sourceValue, $key) use (&$result) {
                $result = __::set($result, $key, $sourceValue);
            });

            return $result;
        }, []);
    }

    /**
     * Reduces $collection to a value which is the $accumulator result of running each
     * element in $collection - from right to left - thru $iterateFn, where each
     * successive invocation is supplied the return value of the previous.
     *
     * If $accumulator is not given, the first element of $collection is used as the
     * initial value.
     *
     * The $iterateFn is invoked with four arguments:
     * ($accumulator, $value, $index|$key, $collection).
     *
     * @usage __::reduceRight(['a', 'b', 'c'], function ($word, $char) {
     *                return $word . $char;
     *            }, '');
     *        >> 'cba'
     *
     * @param array|object $collection The collection to iterate over.
     * @param \Closure     $iterateFn  The function invoked per iteration.
     * @param mixed        $accumulator
     *
     * @return array|mixed|null (*): Returns the accumulated value.
     */
    public static function reduceRight($collection, Closure $iterateFn, $accumulator = null)
    {
        if ($accumulator === null) {
            $accumulator = array_pop($collection);
        }

        __::doForEachRight(
            $collection,
            function ($value, $key, $collection) use (&$accumulator, $iterateFn) {
                $accumulator = $iterateFn($accumulator, $value, $key, $collection);
            }
        );

        return $accumulator;
    }

    /**
     * Iterate over elements of the collection, from right to left, and invokes iterate
     * for each element.
     *
     * The iterate is invoked with three arguments: (value, index|key, collection).
     * Iterate functions may exit iteration early by explicitly returning false.
     *
     * @usage __::doForEachRight([1, 2, 3], function ($value) { print_r($value) });
     *        >> (Side effect: print 3, 2, 1)
     *
     * @param array|object $collection The collection to iterate over.
     * @param \Closure     $iterateFn  The function to call for each value.
     *
     * @return boolean
     */
    public static function doForEachRight($collection, Closure $iterateFn)
    {
        __::doForEach(__::iteratorReverse($collection), $iterateFn);
        return true;
    }

    /**
     * Iterate over elements of the collection and invokes iterate for each element.
     *
     * The iterate is invoked with three arguments: (value, index|key, collection).
     * Iterate functions may exit iteration early by explicitly returning false.
     *
     * @usage __::doForEach([1, 2, 3], function ($value) { print_r($value) });
     *        >> (Side effect: print 1, 2, 3)
     *
     * @param array|object $collection The collection to iterate over.
     * @param \Closure     $iterateFn  The function to call for each value
     *
     * @return boolean
     */
    public static function doForEach($collection, Closure $iterateFn)
    {
        foreach ($collection as $key => $value) {
            if ($iterateFn($value, $key, $collection) === false) {
                break;
            }
        }
        return true;
    }

    /**
     * @param array $iterable
     *
     * @return \Generator
     */
    public static function iteratorReverse($iterable)
    {
        for (end($iterable); ($key = key($iterable)) !== null; prev($iterable)) {
            yield $key => current($iterable);
        }
    }

    /**
     * Return a new collection with the item set at index to given value.
     * Index can be a path of nested indexes.
     *
     * If a portion of path doesn't exist, it's created. Arrays are created for missing
     * index in an array; objects are created for missing property in an object.
     *
     * @usage __::set(['foo' => ['bar' => 'ter']], 'foo.baz.ber', 'fer');
     *        >> '['foo' => ['bar' => 'ter', 'baz' => ['ber' => 'fer']]]'
     *
     * @param array|object    $collection collection of values
     * @param string|int|null $path       key or index
     * @param mixed           $value      the value to set at position $key
     *
     * @throws \Exception if the path consists of a non collection and strict is set to false
     *
     * @return array|object the new collection with the item set
     */
    public static function set($collection, $path, $value = null)
    {
        if ($path === null) {
            return $collection;
        }
        $portions = __::split($path, '.', 2);
        $key = $portions[0];
        if (count($portions) === 1) {
            return __::universalSet($collection, $key, $value);
        }
        // Here we manage the case where the portion of the path points to nothing,
        // or to a value that does not match the type of the source collection
        // (e.g. the path portion 'foo.bar' points to an integer value, while we
        // want to set a string at 'foo.bar.fun'. We first set an object or array
        //  - following the current collection type - to 'for.bar' before setting
        // 'foo.bar.fun' to the specified value).
        if (!__::has($collection, $key)
            || (__::isObject($collection) && !__::isObject(__::get($collection, $key)))
            || (__::isArray($collection) && !__::isArray(__::get($collection, $key)))
        ) {
            $collection = __::universalSet($collection, $key, __::isObject($collection) ? new stdClass : []);
        }

        return __::universalSet($collection, $key, __::set(__::get($collection, $key), $portions[1], $value));
    }

    /**
     * @param mixed $collection
     * @param mixed $key
     * @param mixed $value
     *
     * @return mixed
     */
    public static function universalSet($collection, $key, $value)
    {
        $set_object = function ($object, $key, $value) {
            $newObject = clone $object;
            $newObject->$key = $value;

            return $newObject;
        };
        $set_array = function ($array, $key, $value) {
            $array[$key] = $value;

            return $array;
        };
        $setter = __::isObject($collection) ? $set_object : $set_array;

        return call_user_func_array($setter, [$collection, $key, $value]);
    }

    /**
     * Returns if $input contains all requested $keys. If $strict is true it also checks if $input exclusively contains
     * the given $keys.
     *
     * @usage __::hasKeys(['foo' => 'bar', 'foz' => 'baz'], ['foo', 'foz']);
     *        >> true
     *
     * @param array   $collection of key values pairs
     * @param array   $keys       collection of keys to look for
     * @param boolean $strict     to exclusively check
     *
     * @return boolean
     */
    public static function hasKeys($collection = [], array $keys = [], bool $strict = false): bool
    {
        $keyCount = count($keys);
        if ($strict && count($collection) !== $keyCount) {
            return false;
        }

        return __::every(
            __::map($keys, function ($key) use ($collection) {
                return __::has($collection, $key);
            }),
            function ($v) {
                return $v === true;
            }
        );
    }

    /**
     * Return true if $collection contains the requested $key.
     *
     * In constraint to isset(), __::has() returns true if the key exists but is null.
     *
     * @usage __::has(['foo' => ['bar' => 'num'], 'foz' => 'baz'], 'foo.bar');
     *        >> true
     *
     *        __::hasKeys((object) ['foo' => 'bar', 'foz' => 'baz'], 'bar');
     *        >> false
     *
     * @param array|object $collection of key values pairs
     * @param string       $path       Path to look for.
     *
     * @return boolean
     */
    public static function has($collection, $path): bool
    {
        $portions = __::split($path, '.', 2);
        $key = $portions[0];

        if (count($portions) === 1) {
            return array_key_exists($key, (array)$collection);
        }

        return __::has(__::get($collection, $key), $portions[1]);
    }

    /**
     * Combines and concat collections provided with each others.
     *
     * If the collections have common keys, then the values are appended in an array.
     * If numerical indexes are passed, then values are appended.
     *
     * For a recursive merge, see __::merge.
     *
     * @usage __::concat(['color' => ['favorite' => 'red', 5], 3], [10, 'color' => ['favorite' => 'green', 'blue']]);
     *        >> ['color' => ['favorite' => ['green'], 5, 'blue'], 3, 10]
     *
     * @param array|object $collection1 Collection to assign to.
     * @param array|object $collection2 Other collections to assign.
     *
     * @return array|object Assigned collection.
     */
    public static function concat($collection1, $collection2)
    {
        $isObject = __::isObject($collection1);

        $args = __::map(func_get_args(), function ($arg) {
            return (array)$arg;
        });

        $merged = call_user_func_array('array_merge', $args);

        return $isObject ? (object)$merged : $merged;
    }

    /**
     * Recursively combines and concat collections provided with each others.
     *
     * If the collections have common keys, then the values are appended in an array.
     * If numerical indexes are passed, then values are appended.
     *
     * For a non-recursive concat, see __::concat.
     *
     * @usage __::concatDeep(['color' => ['favorite' => 'red', 5], 3], [10, 'color' => ['favorite' => 'green',
     *        'blue']]);
     *        >> ['color' => ['favorite' => ['red', 'green'], 5, 'blue'], 3, 10]
     *
     * @param array|object $collection1 First collection to concatDeep.
     * @param array|object $collection2 other collections to concatDeep.
     *
     * @return array|object Concatenated collection.
     */
    public static function concatDeep($collection1, $collection2)
    {
        return __::reduceRight(func_get_args(), function ($source, $result) {
            __::doForEach($source, function ($sourceValue, $key) use (&$result) {
                if (!__::has($result, $key)) {
                    $result = __::set($result, $key, $sourceValue);
                } else {
                    if (is_numeric($key)) {
                        $result = __::concat($result, [$sourceValue]);
                    } else {
                        $resultValue = __::get($result, $key);
                        $result = __::set($result, $key, __::concatDeep(
                            __::isCollection($resultValue) ? $resultValue : (array)$resultValue,
                            __::isCollection($sourceValue) ? $sourceValue : (array)$sourceValue
                        ));
                    }
                }
            });

            return $result;
        }, []);
    }

    /**
     * Flattens a complex collection by mapping each ending leafs value to a key consisting of all previous indexes.
     *
     * @usage __::ease(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]);
     *        >> '['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']'
     *
     * @param array  $collection array of values
     * @param string $glue       glue between key path
     *
     * @return array flatten collection
     */
    public static function ease(array $collection, string $glue = '.'): array
    {
        $map = [];
        __::internalEase($map, $collection, $glue);

        return $map;
    }

    /**
     * Inner function for collections::ease
     *
     * @param array  $map
     * @param array  $array
     * @param string $glue
     * @param string $prefix
     */
    private static function internalEase(array &$map, array $array, string $glue, string $prefix = '')
    {
        foreach ($array as $index => $value) {
            if (is_array($value)) {
                __::internalEase($map, $value, $glue, $prefix . $index . $glue);
            } else {
                $map[$prefix . $index] = $value;
            }
        }
    }

    /**
     * Checks if predicate returns truthy for all elements of collection.
     *
     * Iteration is stopped once predicate returns falsey.
     * The predicate is invoked with three arguments: (value, index|key, collection).
     *
     * @usage __::every([1, 3, 4], function ($v) { return is_int($v); });
     *        >> true
     *
     * @param array|object $collection The collection to iterate over.
     * @param \Closure     $iterateFn  The function to call for each value.
     *
     * @return bool
     */
    public static function every($collection, Closure $iterateFn): bool
    {
        $truthy = true;

        __::doForEach(
            $collection,
            function ($value, $key, $collection) use (&$truthy, $iterateFn) {
                $truthy = $truthy && $iterateFn($value, $key, $collection);
                if (!$truthy) {
                    return false;
                }
            }
        );

        return $truthy;
    }

    /**
     * Returns an associative array where the keys are values of $key.
     *
     * @author Chauncey McAskill
     * @link   https://gist.github.com/mcaskill/baaee44487653e1afc0d array_group_by() function.
     *
     * @usage  __::groupBy([
     *                 ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
     *                 ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
     *                 ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
     *             ], 'state');
     *         >> [
     *              'IN' => [
     *                  ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
     *                  ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
     *              ],
     *              'CA' => [
     *                  ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen']
     *              ]
     *            ]
     *
     *
     *         __::groupBy([
     *                 ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
     *                 ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
     *                 ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
     *             ],
     *             function ($value) {
     *                 return $value->city;
     *             }
     *         );
     *         >> [
     *           'Indianapolis' => [
     *              ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
     *              ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
     *           ],
     *           'San Diego' => [
     *              ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
     *           ]
     *         ]
     *
     * @param array $array
     * @param mixed $key
     *
     * @return array
     */
    public static function groupBy(array $array, $key): array
    {
        if (!is_bool($key) && !is_scalar($key) && !is_callable($key)) {
            return $array;
        }
        $grouped = [];
        foreach ($array as $value) {
            $groupKey = null;
            if (is_callable($key)) {
                $groupKey = call_user_func($key, $value);
            } elseif (is_object($value) && property_exists($value, (string)$key)) {
                $groupKey = $value->{$key};
            } elseif (is_array($value) && isset($value[$key])) {
                $groupKey = $value[$key];
            }
            if ($groupKey === null) {
                continue;
            }
            $grouped[$groupKey][] = $value;
        }
        if (($argCnt = func_num_args()) > 2) {
            $args = func_get_args();
            foreach ($grouped as $_key => $value) {
                $params = array_merge([$value], array_slice($args, 2, $argCnt));
                $grouped[$_key] = call_user_func_array('\__::groupBy', $params);
            }
        }

        return $grouped;
    }

    /**
     * Check if value is an empty array or object. We consider any non enumerable as empty.
     *
     * @usage __::isEmpty([]);
     *        >> true
     *
     * @param mixed $value The value to check for emptiness.
     *
     * @return bool
     */
    public static function isEmpty($value): bool
    {
        return (!__::isArray($value) && !__::isObject($value)) || count((array)$value) === 0;
    }

    /**
     * Transforms the keys in a collection by running each key through the iterator
     *
     * @param array    $array   array of values
     * @param \Closure $closure closure to map the keys
     *
     * @throws \Exception if closure doesn't return a valid key that can be used in PHP array
     *
     * @return array
     */
    public static function mapKeys(array $array, Closure $closure = null): array
    {
        if (is_null($closure)) {
            $closure = '__::identity';
        }
        $resultArray = [];
        foreach ($array as $key => $value) {
            $newKey = call_user_func_array($closure, [$key, $value, $array]);
            // key must be a number or string
            if (!is_numeric($newKey) && !is_string($newKey)) {
                throw new Exception('closure must returns a number or string');
            }
            $resultArray[$newKey] = $value;
        }

        return $resultArray;
    }

    /**
     * Transforms the values in a collection by running each value through the iterator
     *
     * @param array    $array   array of values
     * @param \Closure $closure closure to map the values
     *
     * @return array
     */
    public static function mapValues(array $array, Closure $closure = null): array
    {
        if (is_null($closure)) {
            $closure = '__::identity';
        }
        $resultArray = [];
        foreach ($array as $key => $value) {
            $resultArray[$key] = call_user_func_array($closure, [$value, $key, $array]);
        }

        return $resultArray;
    }

    /**
     * Recursively combines and merge collections provided with each others.
     *
     * If the collections have common keys, then the last passed keys override the previous.
     * If numerical indexes are passed, then last passed indexes override the previous.
     *
     * For a non-recursive merge, see __::merge.
     *
     * @usage __::merge(['color' => ['favorite' => 'red', 'model' => 3, 5], 3], [10, 'color' => ['favorite' => 'green',
     *        'blue']]);
     *        >> ['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10]
     *
     * @param array|object $collection1 First collection to merge.
     * @param array|object $collection2 Other collections to merge.
     *
     * @return array|object Concatenated collection.
     */
    public static function merge($collection1, $collection2)
    {
        return __::reduceRight(func_get_args(), function ($source, $result) {
            __::doForEach($source, function ($sourceValue, $key) use (&$result) {
                $value = $sourceValue;
                if (__::isCollection($value)) {
                    $value = __::merge(__::get($result, $key), $sourceValue);
                }
                $result = __::set($result, $key, $value);
            });

            return $result;
        }, []);
    }

    /**
     * Returns an array having only keys present in the given path list. Values for missing keys values will be filled
     * with provided default value.
     *
     * @usage __::pick(['a' => 1, 'b' => ['c' => 3, 'd' => 4]], ['a', 'b.d']);
     *        >> ['a' => 1, 'b' => ['d' => 4]]
     *
     * @param array|object $collection The collection to iterate over.
     * @param array        $paths      array paths to pick
     * @param null         $default
     *
     * @return array|object
     */
    public static function pick($collection = [], array $paths = [], $default = null)
    {
        return __::reduce($paths, function ($results, $path) use ($collection, $default) {
            return __::set($results, $path, __::get($collection, $path, $default));
        }, __::isObject($collection) ? new stdClass() : []);
    }

    /**
     * Reduces $collection to a value which is the $accumulator result of running each
     * element in $collection thru $iterateFn, where each successive invocation is supplied
     * the return value of the previous.
     *
     * If $accumulator is not given, the first element of $collection is used as the
     * initial value.
     *
     * The $iterateFn is invoked with four arguments:
     * ($accumulator, $value, $index|$key, $collection).
     *
     * @usage __::reduce([1, 2], function ($sum, $number) {
     *                return $sum + $number;
     *            }, 0);
     *        >> 3
     *
     *        $a = [
     *            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
     *            ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
     *            ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
     *            ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
     *            ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
     *        ];
     *        $iterateFn = function ($accumulator, $value) {
     *            if (isset($accumulator[$value['city']]))
     *                $accumulator[$value['city']]++;
     *            else
     *                $accumulator[$value['city']] = 1;
     *            return $accumulator;
     *        };
     *        __::reduce($c, $iterateFn, []);
     *        >> [
     *            'Indianapolis' => 2,
     *            'Plainfield' => 1,
     *            'San Diego' => 1,
     *            'Mountain View' => 1,
     *         ]
     *
     *        $object = new \stdClass();
     *        $object->a = 1;
     *        $object->b = 2;
     *        $object->c = 1;
     *        __::reduce($object, function ($result, $value, $key) {
     *            if (!isset($result[$value]))
     *                $result[$value] = [];
     *            $result[$value][] = $key;
     *            return $result;
     *        }, [])
     *        >> [
     *             '1' => ['a', 'c'],
     *             '2' => ['b']
     *         ]
     *
     * @param array      $collection The collection to iterate over.
     * @param \Closure   $iterateFn  The function invoked per iteration.
     * @param array|null $accumulator
     *
     * @return array|mixed|null (*): Returns the accumulated value.
     */
    public static function reduce($collection, Closure $iterateFn, $accumulator = null)
    {
        if ($accumulator === null) {
            $accumulator = array_shift($collection);
        }
        __::doForEach(
            $collection,
            function ($value, $key, $collection) use (&$accumulator, $iterateFn) {
                $accumulator = $iterateFn($accumulator, $value, $key, $collection);
            }
        );

        return $accumulator;
    }

    /**
     * Builds a multidimensional collection out of a hash map using the key as indicator where to put the value.
     *
     * @usage __::unease(['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']);
     *        >> '['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]'
     *
     * @param array  $collection hash map of values
     * @param string $separator  the glue used in the keys
     *
     * @return array
     * @throws \Exception
     */
    public static function unease(array $collection, string $separator = '.'): array
    {
        $nonDefaultSeparator = $separator !== '.';
        $map = [];

        foreach ($collection as $key => $value) {
            $map = __::set(
                $map,
                $nonDefaultSeparator ? str_replace($separator, '.', $key) : $key,
                $value
            );
        }

        return $map;
    }
}
