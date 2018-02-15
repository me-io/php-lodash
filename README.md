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
│       ├── Arrays.php            # Methods related to arrays
│       ├── Collections.php       # Methods related to collections
│       ├── Functions.php         # Methods related to functions
│       ├── Objects.php           # Methods related to objects
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

### Benchmarks

<div align="center">
  <img src="https://dr5mo5s7lqrtc.cloudfront.net/items/3P0x2a0G0v06231u2O1H/screenshot-2.png" alt="benchmark" />
</div>


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

##### [`__::append()`](src/Traits/Arrays.php)

Append item to array

```php
__::append([1, 2, 3], 4);
// >> [1, 2, 3, 4]
```

##### [`__::compact()`](src/Traits/Arrays.php)

Returns a copy of the array with falsy values removed.

```php
__::compact([0, 1, false, 2, '', 3]);
// >> [1, 2, 3]
```

##### [`__::flatten()`](src/Traits/Arrays.php)

Flattens a multidimensional array. If you pass shallow, the array will only be flattened a single level.

```php
__::flatten([1, 2, [3, [4]]], [flatten]);
// >> [1, 2, 3, 4]
```

##### [`__::patch()`](src/Traits/Arrays.php)

Patches array with list of xpath-value pairs.

```php
__::patch(['addr' => ['country' => 'US', 'zip' => 12345]], ['/addr/country' => 'CA', '/addr/zip' => 54321]);
// >> ['addr' => ['country' => 'CA', 'zip' => 54321]]
```

##### [`__::prepend()`](src/Traits/Arrays.php)

```php
__::prepend([1, 2, 3], 4);
// >> [4, 1, 2, 3]
```

##### [`__::range()`](src/Traits/Arrays.php)

Returns an array of integers from start to stop (exclusive) by step.

```php
__::range(1, 10, 2);
// >> [1, 3, 5, 7, 9]
```

##### [`__::repeat($val, $n)`](src/Traits/Arrays.php)

Returns an array of `$n` length with each index containing the provided value.

```php
__::repeat('foo', 3);
// >> ['foo', 'foo', 'foo']
```

#### [`__::chunk()`](src/Traits/Arrays.php)

Split an array into chunks

```php
__::chunk([1, 2, 3, 4, 5], 3);
// >> [[1, 2, 3], [4, 5]]
```

#### [`__::drop()`](src/Traits/Arrays.php)

Creates a slice of array with n elements dropped from the beginning.

```php
__::drop([0, 1, 3], 2);
// >> [3]
```

#### [`__::randomize()`](src/Traits/Arrays.php)

Shuffle an array ensuring no item remains in the same position.

```php
__::randomize([1, 2, 3]);
// → [2, 3, 1]
```

### Chaining

`coming soon...`

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
```php
$string = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et mi orci.';
__::truncate($string);
// >> 'Lorem ipsum dolor sit amet, consectetur...'

__::truncate($string, 60);
// >> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pel...'
```

##### [`__::urlify($string)`](src/Traits/Functions.php)
```php
__::urlify('I love https://google.com');
// >> 'I love <a href="https://google.com">google.com</a>'
```


### Objects

##### [`__::isArray($array)`](src/Traits/Objects.php)
```php
__::isArray([1, 2, 3]);
// >> true

__::isArray(123);
// >> false
```

##### [`__::isFunction($string)`](src/Traits/Objects.php)
```php
__::isFunction(function ($a) { return $a + 2; });
// >> true
```

##### [`__::isNull($null)`](src/Traits/Objects.php)
```php
__::isNull(null);
// >> true
```

##### [`__::isNumber($int|$float)`](src/Traits/Objects.php)
```php
__::isNumber(123);
// >> true
```

##### [`__::isObject($object)`](src/Traits/Objects.php)
```php
__::isObject('fred');
// >> false
```

##### [`__::isString($string)`](src/Traits/Objects.php)
```php
__::isString('fred');
// >> true
```


### Utilities
##### [`__::isEmail($string)`](src/Traits/Objects.php)
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
| [<img src="https://avatars0.githubusercontent.com/u/45731?v=3" width="100px;"/><br /><sub><b>Mohamed Meabed</b></sub>](https://github.com/Meabed)<br />[💻](https://github.com//php-lodash/commits?author=Meabed "Code") [📢](#talk-Meabed "Talks") | [<img src="https://avatars2.githubusercontent.com/u/16267321?v=3" width="100px;"/><br /><sub><b>Zeeshan Ahmad</b></sub>](https://github.com/zeeshanu)<br />[💻](https://github.com//php-lodash/commits?author=zeeshanu "Code") [🐛](https://github.com//php-lodash/issues?q=author%3Azeeshanu "Bug reports") [⚠️](https://github.com//php-lodash/commits?author=zeeshanu "Tests") [📖](https://github.com//php-lodash/commits?author=zeeshanu "Documentation") |
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
