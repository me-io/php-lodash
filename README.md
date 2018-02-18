<h1 align="center">
  PHP Lodash
</h1>
<p align="center" style="font-size: 1.2rem;">
lodash-php is a PHP utility library, similar to Underscore/Lodash, that utilizes `namespace`s and dynamic auto loading to improve library performance.
</p>
<hr />

[![Build Status][build-badge]][build]
[![Code Cov][codecov-badge]][codecov]
[![Scrutinizer][scrutinizer-badge]][scrutinizer]
[![downloads][downloads-badge]][downloads]
[![MIT License][license-badge]][license]

[![All Contributors](https://img.shields.io/badge/all_contributors-2-orange.svg?style=flat-square)](#contributors)
[![PRs Welcome][prs-badge]][prs]
[![Code of Conduct][coc-badge]][coc]
[![Watch on GitHub][github-watch-badge]][github-watch]
[![Star on GitHub][github-star-badge]][github-star]
[![Tweet][twitter-badge]][twitter]

## Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
- [Structure](#structure)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Requirements

This library requires php `php_mbstring` extension. To enable this extension open your `php.ini` file and find for the line `extension=php_mbstring.dll` and uncomment it. If this line is not there then manually add this line in `php.ini`.

```ini
extension=php_mbstring.dll
```

## Introduction

`lodash-php` is a PHP utility library, similar to `Underscore/Lodash`, that utilizes `namespace`s and dynamic auto loading to improve library performance.

### Project Structure

- `lodash.php` is the entry point for the `lodash-php` utility library
- All lodash-php methods are stored in separate files within their respective `namespace` folder outlined in `/src/__`
- Tests reflect the `namespace` defined within the library and are processed using [phpunit testing](https://phpunit.de)
  - To run tests run the following command `phpunit`

```bash
.
├── images                        # Place relevant graphics in this folder
├── src                           # Core code of the application.
│   ├── __.php                    # Entry point for the library                  
│   └── Traits                    # Contains all lodash-php methods
│       ├── Sequence\Chain.php    # Methods related to chaining
│       ├── Arrays.php            # Methods related to arrays
│       ├── Collections.php       # Methods related to collections
│       ├── Functions.php         # Methods related to functions
│       ├── Objects.php           # Methods related to objects
│       ├── Strings.php           # Methods related to strings
│       └── Utilities.php         # Methods related to utilities
├── tests                         # Tests are placed in that folder.
├── composer.json                 # This file defines the project requirements
├── phpunit.xml                   # Contains the configuration for PHPUnit.
├── LICENSE                       # License file for `lodash-php`
└── README.md                     # Introduces our library to user.
```

---

<p align="center">
    <b>NOTE:</b> lodash-php is not currently in feature parity with Underscore/Lodash. Review the <a href="#contributing">contributing</a> section for more information.
</p>

---

## Installation

Just add `me-io/php-lodash` to your project composer.json file:

```json
{
    "require": {
        "me-io/php-lodash": "^1"
    }
}
```

and then run composer install. This will install `me-io/php-lodash` and all it's dependencies. Or run the following command:

```bash
composer require me-io/php-lodash
```

## Usage

### Arrays

##### [`__::append(array $array = [], $value = null)`](src/Traits/Arrays.php)

Append item to array

```php
__::append([1, 2, 3], 4);
// >> [1, 2, 3, 4]
```

##### [`__::compact(array $array = [])`](src/Traits/Arrays.php)

Returns a copy of the array with falsy values removed.

```php
__::compact([0, 1, false, 2, '', 3]);
// >> [1, 2, 3]
```

##### [`__::flatten($array, $shallow = false)`](src/Traits/Arrays.php)

Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.

```php
__::flatten([1, 2, [3, [4]]], [flatten]);
// >> [1, 2, 3, 4]
```

##### [`__::patch($arr, $patches, $parent = '')`](src/Traits/Arrays.php)

Patches array with list of xpath-value pairs.

```php
__::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
// >> ['addr' => ['country' => 'CA', 'zip' => 54321]]
```

##### [`__::prepend(array $array = [], $value = null)`](src/Traits/Arrays.php)

```php
__::prepend([1, 2, 3], 4);
// >> [4, 1, 2, 3]
```

##### [`__::range($start = null, $stop = null, $step = 1)`](src/Traits/Arrays.php)

Returns an array of integers from start to stop (exclusive) by step.

```php
__::range(1, 10, 2);
// >> [1, 3, 5, 7, 9]
```

##### [`__::repeat($object = '', $times = null)`](src/Traits/Arrays.php)

Returns an array of `$n` length with each index containing the provided value.

```php
__::repeat('foo', 3);
// >> ['foo', 'foo', 'foo']
```

#### [`__::chunk(array $array, $size = 1, $preserveKeys = false)`](src/Traits/Arrays.php)

Split an array into chunks

```php
__::chunk([1, 2, 3, 4, 5], 3);
// >> [[1, 2, 3], [4, 5]]
```

#### [`__::drop(array $input, $number = 1)`](src/Traits/Arrays.php)

Creates a slice of array with n elements dropped from the beginning.

```php
__::drop([0, 1, 3], 2);
// >> [3]
```

#### [`__::randomize(array $array)`](src/Traits/Arrays.php)

Shuffle an array ensuring no item remains in the same position.

```php
__::randomize([1, 2, 3]);
// >> [2, 3, 1]
```

#### [`__::search($array, $value)`](src/Traits/Arrays.php)

Search for the index of a value in an array.

```php
__::search(['a', 'b', 'c'], 'b');
// >> 1
```

#### [`__::average($array, $decimals)`](src/Traits/Arrays.php)

Returns the average value of an array.

```php
__::average([1, 2, 3]);
// >> 2
```

#### [`__::size($array)`](src/Traits/Arrays.php)

Get the size of an array.

```php
__::size([1, 2, 3]);
// >> 3
```

#### [`__::contains($array, $value)`](src/Traits/Arrays.php)

Check if an item is in an array.

```php
__::contains(['a', 'b', 'c'], 'b');
// >> true
```

#### [`__::clean(array $array)`](src/Traits/Arrays.php)

Clean all falsy values from an array.

```php
__::clean([true, false, 0, 1, 'string', '']);
// >> [true, 1, 'string']
```

#### [`__::random(array $array, $take = null)`](src/Traits/Arrays.php)

Get a random string from an array.

```php
__::random([1, 2, 3]);
// >> Returns 1, 2 or 3
```

#### [`__::intersection(array $a, array $b)`](src/Traits/Arrays.php)

Return an array with all elements found in both input arrays.

```php
__::intersection(["green", "red", "blue"], ["green", "yellow", "red"]);
// >> ["green", "red"]
```

#### [`__::intersects(array $a, array $b)`](src/Traits/Arrays.php)

Return a boolean flag which indicates whether the two input arrays have any common elements.

```php
__::intersects(["green", "red", "blue"], ["green", "yellow", "red"])
// >> true
```

#### [`__::initial(array $array, int $to = 1)`](src/Traits/Arrays.php)

Exclude the last X elements from an array

```php
__::initial([1, 2, 3], 1);
// >> [1, 2]
```

#### [`__::rest(array $array, int $from = 1)`](src/Traits/Arrays.php)

Exclude the first X elements from an array

```php
__::rest([1, 2, 3], 2);
// >> [3]
```

#### [`__::sortKeys(array $array, string $direction = 'ASC')`](src/Traits/Arrays.php)

Sort an array by key.

```php
__::sortKeys(['z' => 0, 'b' => 1, 'r' => 2]);
// >> ['b' => 1, 'r' => 2, 'z' => 0]

__::sortKeys(['z' => 0, 'b' => 1, 'r' => 2], 'desc');
// >> ['z' => 0, 'r' => 2, 'b' => 1]
```

### Chaining

#### [`__::chain($initialValue)`](src/Traits/Sequence/Chain.php)

Returns a wrapper instance, allows the value to be passed through multiple php-lodash functions

```php
__::chain([0, 1, 2, 3, null])
    ->compact()
    ->prepend(4)
    ->value();
// >> [4, 1, 2, 3]
```

### Collections

##### [`__::filter($array, callback($n))`](src/Traits/Collections.php)

Returns the values in the collection that pass the truth test.

```php
$a = [
    ['name' => 'fred',   'age' => 32],
    ['name' => 'maciej', 'age' => 16]
];

__::filter($a, function($n) {
    return $n['age'] > 24;
});
// >> [['name' => 'fred', 'age' => 32]]
```

##### [`__::first($array, [$n])`](src/Traits/Collections.php)

Gets the first element of an array. Passing n returns the first n elements.

```php
__::first([1, 2, 3, 4, 5], 2);
// >> [1, 2]
```

##### [`__::get($array, JSON $string)`](src/Traits/Collections.php)

Get item of an array by index, aceepting nested index

```php
__::get(['foo' => ['bar' => 'ter']], 'foo.bar');
// >> 'ter'
```

##### [`__::last($array, [$n])`](src/Traits/Collections.php)

Gets the last element of an array. Passing n returns the last n elements.

```php
__::last([1, 2, 3, 4, 5], 2);
// >> [4, 5]
```

##### [`__::map($array, callback($n))`](src/Traits/Collections.php)

Returns an array of values by mapping each in collection through the iterator.

```php
__::map([1, 2, 3], function($n) {
    return $n * 3;
});
// >> [3, 6, 9]
```

##### [`__::max($array)`](src/Traits/Collections.php)

Returns the maximum value from the collection. If passed an iterator, max will return max value returned by the iterator.

```php
__::max([1, 2, 3]);
// >> 3
```

##### [`__::min($array)`](src/Traits/Collections.php)

Returns the minimum value from the collection. If passed an iterator, min will return min value returned by the iterator.

```php
__::min([1, 2, 3]);
// >> 1
```

##### [`__::pluck($array, $property)`](src/Traits/Collections.php)

Returns an array of values belonging to a given property of each item in a collection.

```php
$a = [
    ['foo' => 'bar',  'bis' => 'ter' ],
    ['foo' => 'bar2', 'bis' => 'ter2'],
];

__::pluck($a, 'foo');
// >> ['bar', 'bar2']
```

##### [`__::where($array, $parameters[])`](src/Traits/Collections.php)

Returns a collection of objects matching the given array of parameters.

```php
$a = [
    ['name' => 'fred',   'age' => 32],
    ['name' => 'maciej', 'age' => 16]
];

__::where($a, ['age' => 16]);
// >> [['name' => 'maciej', 'age' => 16]]
```

#### [`__::assign($collection1, $collection2)`](src/Traits/Collections.php)

Combines and merge collections provided with each others.

```php
$a = [
    'color' => [
        'favorite' => 'red', 
        5
    ], 
    3
];
$b = [
    10, 
    'color' => [
        'favorite' => 'green', 
        'blue'
    ]
];

__::assign($a, $b);
// >> ['color' => ['favorite' => 'green', 'blue'], 10]
```

#### [`__::reduceRight($collection, \Closure $iteratee, $accumulator = null)`](src/Traits/Collections.php)

Reduces $collection to a value which is the $accumulator result of running each element in $collection - from right to left - thru $iteratee, where each successive invocation is supplied the return value of the previous.

```php
__::reduceRight(['a', 'b', 'c'], function ($word, $char) {
    return $word . $char;
}, '');
// >> 'cba'
```

#### [`__::doForEachRight($collection, \Closure $iteratee)`](src/Traits/Collections.php)

Iterate over elements of the collection, from right to left, and invokes iterate for each element.

```php
__::doForEachRight([1, 2, 3], function ($value) { print_r($value) });
// >> (Side effect: print 3, 2, 1)
```

#### [`__::doForEach($collection, \Closure $iteratee)`](src/Traits/Collections.php)

Iterate over elements of the collection and invokes iterate for each element.

```php
__::doForEach([1, 2, 3], function ($value) { print_r($value) });
// >> (Side effect: print 1, 2, 3)
```

#### [`__::set($collection, $path, $value = null)`](src/Traits/Collections.php)

Return a new collection with the item set at index to given value. Index can be a path of nested indexes.

```php
__::set(['foo' => ['bar' => 'ter']], 'foo.baz.ber', 'fer');
// >> '['foo' => ['bar' => 'ter', 'baz' => ['ber' => 'fer']]]'
```

#### [`__::hasKeys($collection, $path, $value = null)`](src/Traits/Collections.php)

Returns if $input contains all requested $keys. If $strict is true it also checks if $input exclusively contains the given $keys.

```php
__::hasKeys(['foo' => 'bar', 'foz' => 'baz'], ['foo', 'foz']);
// >> true
```

#### [`__::has($collection, $path)`](src/Traits/Collections.php)

Return true if $collection contains the requested $key.

```php
__::has(['foo' => ['bar' => 'num'], 'foz' => 'baz'], 'foo.bar');
// >> true

__::hasKeys((object) ['foo' => 'bar', 'foz' => 'baz'], 'bar');
// >> false
```

#### [`__::concat($collection1, $collection2)`](src/Traits/Collections.php)

Combines and concat collections provided with each others.

```php
__::concat(['color' => ['favorite' => 'red', 5], 3], [10, 'color' => ['favorite' => 'green', 'blue']]);
// >> ['color' => ['favorite' => ['green'], 5, 'blue'], 3, 10]
```

#### [`__::concatDeep($collection1, $collection2)`](src/Traits/Collections.php)

Recursively combines and concat collections provided with each others.

```php
__::concatDeep(['color' => ['favorite' => 'red', 5], 3], [10, 'color' => ['favorite' => 'green', 'blue']]);
// >> ['color' => ['favorite' => ['red', 'green'], 5, 'blue'], 3, 10]
```

#### [`__::ease(array $collection, $glue = '.')`](src/Traits/Collections.php)

Flattens a complex collection by mapping each ending leafs value to a key consisting of all previous indexes.

```php
__::ease(['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]);
// >> '['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']'
```

#### [`__::every($collection, \Closure $iteratee)`](src/Traits/Collections.php)

Checks if predicate returns truthy for all elements of collection.

```php
__::every([1, 3, 4], function ($v) { return is_int($v); });
// → true
```

#### [`__::groupBy(array $array, $key)`](src/Traits/Collections.php)

Returns an associative array where the keys are values of $key.

```php
__::groupBy([
        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
        ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
        ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
    ],
    'state'
);
// >> [
//   'IN' => [
//      ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
//      ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
//   ],
//   'CA' => [
//      ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen']
//   ]
// ]

__::groupBy([
        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
        ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
        ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
    ],
    function ($value) {
        return $value->city;
    }
);
// >> [
//   'Indianapolis' => [
//      ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
//      ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
//   ],
//   'San Diego' => [
//      ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
//   ]
// ]
```

#### [`__::isEmpty($value)`](src/Traits/Collections.php)

Check if value is an empty array or object.

```php
__::isEmpty([]);
// >> true
```

#### [`__::merge($collection1, $collection2)`](src/Traits/Collections.php)

Recursively combines and merge collections provided with each others.

```php
__::merge(['color' => ['favorite' => 'red', 'model' => 3, 5], 3], [10, 'color' => ['favorite' => 'green', 'blue']]);
// >> ['color' => ['favorite' => 'green', 'model' => 3, 'blue'], 10]
```

#### [`__::pick($collection = [], array $paths = [], $default = null)`](src/Traits/Collections.php)

Returns an array having only keys present in the given path list.

```php
__::pick(['a' => 1, 'b' => ['c' => 3, 'd' => 4]], ['a', 'b.d']);
// >> ['a' => 1, 'b' => ['d' => 4]]
```

#### [`__::reduce($collection, \Closure $iteratee, $accumulator = null)`](src/Traits/Collections.php)

Reduces $collection to a value which is the $accumulator result of running each element in $collection thru $iteratee, where each successive invocation is supplied the return value of the previous.

```php
__::reduce([1, 2], function ($sum, $number) {
    return $sum + $number;
}, 0);
// >> 3

$a = [
    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'School bus'],
    ['state' => 'IN', 'city' => 'Indianapolis', 'object' => 'Manhole'],
    ['state' => 'IN', 'city' => 'Plainfield', 'object' => 'Basketball'],
    ['state' => 'CA', 'city' => 'San Diego', 'object' => 'Light bulb'],
    ['state' => 'CA', 'city' => 'Mountain View', 'object' => 'Space pen'],
];
$iteratee = function ($accumulator, $value) {
    if (isset($accumulator[$value['city']]))
        $accumulator[$value['city']]++;
    else
        $accumulator[$value['city']] = 1;
    return $accumulator;
};
__::reduce($c, $iteratee, []);
// >> [
// >>    'Indianapolis' => 2,
// >>    'Plainfield' => 1,
// >>    'San Diego' => 1,
// >>    'Mountain View' => 1,
// >> ]

$object = new \stdClass();
$object->a = 1;
$object->b = 2;
$object->c = 1;
__::reduce($object, function ($result, $value, $key) {
    if (!isset($result[$value]))
        $result[$value] = [];
    $result[$value][] = $key;
    return $result;
}, [])
// >> [
// >>     '1' => ['a', 'c'],
// >>     '2' => ['b']
// >> ]
```

#### [`__::unease(array $collection, $separator = '.')`](src/Traits/Collections.php)

Builds a multidimensional collection out of a hash map using the key as indicator where to put the value.

```php
__::unease(['foo.bar' => 'ter', 'baz.0' => 'b', , 'baz.1' => 'z']);
// >> '['foo' => ['bar' => 'ter'], 'baz' => ['b', 'z']]'
```

### Strings

#### [`__::split($input, $delimiter, $limit = PHP_INT_MAX)`](src/Traits/Strings.php)

Split a string by string.

```php
__::split('a-b-c', '-', 2);
// >> ['a', 'b-c']
```

#### [`__::camelCase($input)`](src/Traits/Strings.php)

Converts string to [camel case](https://en.wikipedia.org/wiki/CamelCase).

```php
__::camelCase('Foo Bar');
// >> 'fooBar'
```

#### [`__::capitalize($input)`](src/Traits/Strings.php)

Converts the first character of string to upper case and the remaining to lower case.

```php
__::capitalize('FRED');
// >> 'Fred'
```

#### [`__::kebabCase($input)`](src/Traits/Strings.php)

Converts string to [kebab case](https://en.wikipedia.org/wiki/Letter_case#Special_case_styles).

```php
__::kebabCase('Foo Bar');
// >> 'foo-bar'
```

#### [`__::lowerFirst($input)`](src/Traits/Strings.php)

Converts the first character of string to lower case, like lcfirst.

```php
__::lowerFirst('Fred');
// >> 'fred'
```

#### [`__::snakeCase($input)`](src/Traits/Strings.php)

Converts string to [snake case](https://en.wikipedia.org/wiki/Snake_case).

```php
__::snakeCase('Foo Bar');
// >> 'foo_bar'
```

#### [`__::startCase($input)`](src/Traits/Strings.php)

Converts string to [start case](https://en.wikipedia.org/wiki/Letter_case#Stylistic_or_specialised_usage).

```php
__::startCase('--foo-bar--');
// >> 'Foo Bar'
```

#### [`__::toLower($input)`](src/Traits/Strings.php)

Converts string, as a whole, to lower case just like strtolower.

```php
__::toLower('fooBar');
// >> 'foobar'
```

#### [`__::toUpper($input)`](src/Traits/Strings.php)

Converts string, as a whole, to lower case just like strtoupper.

```php
__::toUpper('fooBar');
// >> 'FOOBAR'
```

#### [`__::upperCase($input)`](src/Traits/Strings.php)

Converts string, as space separated words, to upper case.

```php
__::upperCase('--foo-bar');
// >> 'FOO BAR'
```

#### [`__::upperFirst($input)`](src/Traits/Strings.php)

Converts the first character of string to upper case, like ucfirst.

```php
__::upperFirst('fred');
// >> 'Fred'
```

#### [`__::words($input, $pattern = null)`](src/Traits/Strings.php)

Splits string into an array of its words.

```php
__::words('fred, barney, & pebbles');
// >> ['fred', 'barney', 'pebbles']

__::words('fred, barney, & pebbles', '/[^, ]+/');
// >> ['fred', 'barney', '&', 'pebbles']
```

#### [`__::lowerCase($input)`](src/Traits/Strings.php)

Converts string, as space separated words, to lower case.

```php
__::lowerCase('--Foo-Bar--');
// >> 'foo bar'
```

### Functions

##### [`__::slug($string, [array $options])`](src/Traits/Functions.php)
```php
__::slug('Jakieś zdanie z dużą ilością obcych znaków!');
// >> 'jakies-zdanie-z-duza-iloscia-obcych-znakow'

$options = [
    'delimiter' => '-',
    'limit' => 30,
    'lowercase' => true,
    'replacements' => array(),
    'transliterate' => true
]

__::slug('Something you don\'t know about know about Jackson', $options);
// >> 'something-you-dont-know-about'
```

##### [`__::truncate($string, [$limit=40])`](src/Traits/Functions.php)

Truncate string based on count of words

```php
$string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';
__::truncate($string);
// >> 'Lorem ipsum dolor sit amet, consectetur...'

__::truncate($string, 60);
// >> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pel...'
```

##### [`__::urlify($string)`](src/Traits/Functions.php)

Find the urls inside a string a put them inside anchor tags

```php
__::urlify('I love https://google.com');
// >> 'I love <a href="https://google.com">google.com</a>'
```

### Objects

##### [`__::isArray($array)`](src/Traits/Objects.php)

Check if give value is array or not.

```php
__::isArray([1, 2, 3]);
// >> true

__::isArray(123);
// >> false
```

##### [`__::isFunction($string)`](src/Traits/Objects.php)

Check if give value is function or not.

```php
__::isFunction(function ($a) { return $a + 2; });
// >> true
```

##### [`__::isNull($null)`](src/Traits/Objects.php)

Check if give value is null or not.

```php
__::isNull(null);
// >> true
```

##### [`__::isNumber($int|$float)`](src/Traits/Objects.php)

Check if give value is number or not.

```php
__::isNumber(123);
// >> true
```

##### [`__::isObject($object)`](src/Traits/Objects.php)

Check if give value is object or not.

```php
__::isObject('fred');
// >> false
```

##### [`__::isString($string)`](src/Traits/Objects.php)

Check if give value is string or not.

```php
__::isString('fred');
// >> true
```

### Utilities

##### [`__::isEmail($string)`](src/Traits/Objects.php)

Check if the value is valid email.

```php
__::isEmail('test@test.com');
// >> true

__::isEmail('test_test.com');
// >> false
```

##### [`__::now()`](src/Traits/Utilities.php)

Wrapper of the [`time()`](http://php.net/manual/en/function.time.php) function that returns the current offset in seconds since the Unix Epoch.

```php
__::now();
// >> 1417546029
```

##### [`__::stringContains($needle, $haystack, [$offset])`](src/Traits/Utilities.php)

Wrapper of the [`time()`](http://php.net/manual/en/function.time.php) function that returns the current offset in seconds since the Unix Epoch.

```php
__::stringContains('waffle', 'wafflecone');
// >> true
```

## Contributing

Please feel free to contribute to this project! Pull requests and feature requests welcome! :v:

## Contributors

A huge thanks to all of our contributors:

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore -->
| [<img src="https://avatars0.githubusercontent.com/u/45731?v=3" width="100px;"/><br /><sub><b>Mohamed Meabed</b></sub>](https://github.com/Meabed)<br />[💻](https://github.com//php-lodash/commits?author=Meabed "Code") [⚠️](https://github.com//php-lodash/commits?author=Meabed "Tests") [📢](#talk-Meabed "Talks") | [<img src="https://avatars2.githubusercontent.com/u/16267321?v=3" width="100px;"/><br /><sub><b>Zeeshan Ahmad</b></sub>](https://github.com/zeeshanu)<br />[💻](https://github.com//php-lodash/commits?author=zeeshanu "Code") [🐛](https://github.com//php-lodash/issues?q=author%3Azeeshanu "Bug reports") [⚠️](https://github.com//php-lodash/commits?author=zeeshanu "Tests") [📖](https://github.com//php-lodash/commits?author=zeeshanu "Documentation") |
| :---: | :---: |
<!-- ALL-CONTRIBUTORS-LIST:END -->

## License

The code is available under the [MIT license](LICENSE.md).

[build-badge]: https://img.shields.io/travis/me-io/php-lodash.svg?style=flat-square
[build]: https://travis-ci.org/me-io/php-lodash
[downloads-badge]: https://img.shields.io/packagist/dm/me-io/php-lodash.svg?style=flat-square
[downloads]: https://packagist.org/packages/me-io/php-lodash/stats
[license-badge]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[license]: https://github.com/me-io/php-lodash/blob/master/LICENSE.md
[prs-badge]: https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square
[prs]: http://makeapullrequest.com
[coc-badge]: https://img.shields.io/badge/code%20of-conduct-ff69b4.svg?style=flat-square
[coc]: https://github.com/me-io/php-lodash/blob/master/CODE_OF_CONDUCT.md
[github-watch-badge]: https://img.shields.io/github/watchers/me-io/php-lodash.svg?style=social
[github-watch]: https://github.com/me-io/php-lodash/watchers
[github-star-badge]: https://img.shields.io/github/stars/me-io/php-lodash.svg?style=social
[github-star]: https://github.com/me-io/php-lodash/stargazers
[twitter]: https://twitter.com/intent/tweet?text=Check%20out%20php-lodash!%20https://github.com/me-io/php-lodash%20%F0%9F%91%8D
[twitter-badge]: https://img.shields.io/twitter/url/https/github.com/me-io/php-lodash.svg?style=social
[codecov-badge]: https://codecov.io/gh/me-io/php-lodash/branch/master/graph/badge.svg
[codecov]: https://codecov.io/gh/me-io/php-lodash
[scrutinizer-badge]: https://scrutinizer-ci.com/g/me-io/php-lodash/badges/quality-score.png?b=master
[scrutinizer]: https://scrutinizer-ci.com/g/me-io/php-lodash/?branch=master
