<?php

namespace __\Traits;

use __;

trait Strings
{
    /**
     * Split a string by string.
     *
     * @link  http://php.net/manual/en/function.explode.php Based on explode
     * @usage __::split('a-b-c', '-', 2);
     *        >> ['a', 'b-c']
     *
     * @param string $input     The string to split.
     * @param string $delimiter The boundary string.
     * @param int    $limit     (optional) If limit is set and positive, the returned array
     *                          will contain a maximum of limit elements with the last element containing the
     *                          rest of string.
     *                          If the limit parameter is negative, all components except the last -limit are returned.
     *                          If the limit parameter is zero, then this is treated as 1.
     *
     * @return array
     */
    public static function split(string $input, string $delimiter, int $limit = PHP_INT_MAX)
    {
        return explode($delimiter, $input, $limit);
    }

    /**
     * Converts string to [camel case](https://en.wikipedia.org/wiki/CamelCase).
     *
     * @usage __::camelCase('Foo Bar');
     *        >> 'fooBar'
     *
     * @param string $input
     *
     * @return string|array
     */
    public static function camelCase(string $input)
    {
        $words = __::words(preg_replace("/['\x{2019}]/u", '', $input));

        return array_reduce(
            $words,
            function ($result, $word) use ($words) {
                $isFirst = __::first($words) === $word;
                $word = __::toLower($word);

                return $result . (!$isFirst ? __::capitalize($word) : $word);
            },
            ''
        );
    }

    /**
     * Converts the first character of string to upper case and the remaining to lower case.
     *
     * @usage __::capitalize('FRED');
     *        >> 'Fred'
     *
     * @param string $input
     *
     * @return string
     */
    public static function capitalize(string $input): string
    {
        return __::upperFirst(__::toLower($input));
    }

    /**
     * Converts string to kebab case.
     *
     * @link  https://en.wikipedia.org/wiki/Letter_case#Special_case_styles kebab case
     *
     * @usage __::kebabCase('Foo Bar');
     *        >> 'foo-bar'
     *
     * @param string $input
     *
     * @return string
     */
    public static function kebabCase(string $input): string
    {
        $words = __::words(preg_replace("/['\x{2019}]/u", '', $input));

        return array_reduce(
            $words,
            function ($result, $word) use ($words) {
                $isFirst = __::first($words) === $word;

                return $result . (!$isFirst ? '-' : '') . __::toLower($word);
            },
            ''
        );
    }

    /**
     * Converts the first character of string to lower case, like lcfirst.
     *
     * @usage __::lowerFirst('Fred');
     *        >> 'fred'
     *
     * @param string $input
     *
     * @return string
     */
    public static function lowerFirst(string $input): string
    {
        return lcfirst($input);
    }

    /**
     * Converts string to snake case.
     *
     * @link  https://en.wikipedia.org/wiki/Snake_case snake case
     *
     * @usage __::snakeCase('Foo Bar');
     *        >> 'foo_bar'
     *
     * @param string $input
     *
     * @return string
     */
    public static function snakeCase(string $input): string
    {
        $words = __::words(preg_replace("/['\x{2019}]/u", '', $input));

        return array_reduce(
            $words,
            function ($result, $word) use ($words) {
                $isFirst = __::first($words) === $word;

                return $result . (!$isFirst ? '_' : '') . __::toLower($word);
            },
            ''
        );
    }

    /**
     * Converts string to start case.
     *
     * @link  https://en.wikipedia.org/wiki/Letter_case#Stylistic_or_specialised_usage start case
     *
     * @usage __::startCase('--foo-bar--');
     *        >> 'Foo Bar'
     *
     * @param string $input
     *
     * @return string
     */
    public static function startCase(string $input): string
    {
        $words = __::words(preg_replace("/['\x{2019}]/u", '', $input));

        return array_reduce(
            $words,
            function ($result, $word) use ($words) {
                $isFirst = __::first($words) === $word;

                return $result . (!$isFirst ? ' ' : '') . __::upperFirst($word);
            },
            ''
        );
    }

    /**
     * Converts string, as a whole, to lower case just like strtolower.
     *
     * @usage __::toLower('fooBar');
     *        >> 'foobar'
     *
     * @param string $input
     *
     * @return string
     */
    public static function toLower(string $input): string
    {
        return strtolower($input);
    }

    /**
     * Converts string, as a whole, to lower case just like strtoupper.
     *
     * @usage __::toUpper('fooBar');
     *        >> 'FOOBAR'
     *
     * @param string $input
     *
     * @return string
     */
    public static function toUpper(string $input): string
    {
        return strtoupper($input);
    }

    /**
     * Converts string, as space separated words, to upper case.
     *
     * @usage __::upperCase('--foo-bar');
     *        >> 'FOO BAR'
     *
     * @param string $input
     *
     * @return string
     */
    public static function upperCase(string $input): string
    {
        $words = __::words(preg_replace("/['\x{2019}]/u", '', $input));

        return array_reduce(
            $words,
            function ($result, $word) use ($words) {
                $isFirst = __::first($words) === $word;

                return $result . (!$isFirst ? ' ' : '') . __::toUpper($word);
            },
            ''
        );
    }

    /**
     * Converts the first character of string to upper case, like ucfirst.
     *
     * @usage __::upperFirst('fred');
     *        >> 'Fred'
     *
     * @param string $input
     *
     * @return string
     */
    public static function upperFirst(string $input): string
    {
        return ucfirst($input);
    }

    /**
     * Splits string into an array of its words.
     *
     * @usage __::words('fred, barney, & pebbles');
     *        >> ['fred', 'barney', 'pebbles']
     *
     *        __::words('fred, barney, & pebbles', '/[^, ]+/');
     *        >> ['fred', 'barney', '&', 'pebbles']
     *
     * @param string|null $input
     * @param string      $pattern : The pattern to match words.
     *
     * @return array
     */
    public static function words(?string $input, $pattern = null)
    {
        /** Used to compose unicode character classes. */
        $rsAstralRange = '\x{e800}-\x{efff}';
        $rsComboMarksRange = '\x{0300}-\x{036f}';
        $reComboHalfMarksRange = '\x{fe20}-\x{fe2f}';
        $rsComboSymbolsRange = '\x{20d0}-\x{20ff}';
        $rsComboRange = $rsComboMarksRange . $reComboHalfMarksRange . $rsComboSymbolsRange;
        $rsDingbatRange = '\x{2700}-\x{27bf}';
        $rsLowerRange = 'a-z\\xdf-\\xf6\\xf8-\\xff';
        $rsMathOpRange = '\\xac\\xb1\\xd7\\xf7';
        $rsNonCharRange = '\\x00-\\x2f\\x3a-\\x40\\x5b-\\x60\\x7b-\\xbf';
        $rsPunctuationRange = '\x{2000}-\x{206f}';
        $rsSpaceRange = ' \\t\\x0b\\f\\xa0\x{feff}\\n\\r\x{2028}\x{2029}\x{1680}\x{180e}\x{2000}\x{2001}\x{2002}\x{2003}\x{2004}\x{2005}\x{2006}\x{2007}\x{2008}\x{2009}\x{200a}\x{202f}\x{205f}\x{3000}';
        $rsUpperRange = 'A-Z\\xc0-\\xd6\\xd8-\\xde';
        $rsVarRange = '\x{fe0e}\x{fe0f}';
        $rsBreakRange = $rsMathOpRange . $rsNonCharRange . $rsPunctuationRange . $rsSpaceRange;
        /** Used to compose unicode capture groups. */
        $rsApos = "['\x{2019}]";
        $rsBreak = '[' . $rsBreakRange . ']';
        $rsCombo = '[' . $rsComboRange . ']';
        $rsDigits = '\\d+';
        $rsDingbat = '[' . $rsDingbatRange . ']';
        $rsLower = '[' . $rsLowerRange . ']';
        $rsMisc = '[^' . $rsAstralRange . $rsBreakRange . $rsDigits . $rsDingbatRange . $rsLowerRange . $rsUpperRange . ']';
        $rsFitz = '\\x{e83c}[\x{effb}-\x{efff}]';
        $rsModifier = '(?:' . $rsCombo . '|' . $rsFitz . ')';
        $rsNonAstral = '[^' . $rsAstralRange . ']';
        $rsRegional = '(?:\x{e83c}[\x{ede6}-\x{edff}]){2}';
        $rsSurrPair = '[\x{e800}-\x{ebff}][\x{ec00}-\x{efff}]';
        $rsUpper = '[' . $rsUpperRange . ']';
        $rsZWJ = '\x{200d}';
        /** Used to compose unicode regexes. */
        $rsMiscLower = '(?:' . $rsLower . '|' . $rsMisc . ')';
        $rsMiscUpper = '(?:' . $rsUpper . '|' . $rsMisc . ')';
        $rsOptContrLower = '(?:' . $rsApos . '(?:d|ll|m|re|s|t|ve))?';
        $rsOptContrUpper = '(?:' . $rsApos . '(?:D|LL|M|RE|S|T|VE))?';
        $reOptMod = $rsModifier . '?';
        $rsOptVar = '[' . $rsVarRange . ']?';
        $rsOrdLower = '\\d*(?:(?:1st|2nd|3rd|(?![123])\\dth)\\b)';
        $rsOrdUpper = '\\d*(?:(?:1ST|2ND|3RD|(?![123])\\dTH)\\b)';
        $asciiWords = '/[^\x00-\x2f\x3a-\x40\x5b-\x60\x7b-\x7f]+/';
        $hasUnicodeWordRegex = '/[a-z][A-Z]|[A-Z]{2,}[a-z]|[0-9][a-zA-Z]|[a-zA-Z][0-9]|[^a-zA-Z0-9 ]/';
        $rsOptJoin = '(?:' . $rsZWJ . '(?:' . join(
            '|',
            [$rsNonAstral, $rsRegional, $rsSurrPair]
        ) . ')' . $rsOptVar . $reOptMod . ')*';
        $rsSeq = $rsOptVar . $reOptMod . $rsOptJoin;
        $rsEmoji = '(?:' . join('|', [$rsDingbat, $rsRegional, $rsSurrPair]) . ')' . $rsSeq;

        /** @var string $unicodeWords unicode words patterns to be used in preg_match */
        $unicodeWords = '/' . join('|', [
                $rsUpper . '?' . $rsLower . '+' . $rsOptContrLower . '(?=' . join(
                    '|',
                    [$rsBreak, $rsUpper, '$']
                ) . ')',
                $rsMiscUpper . '+' . $rsOptContrUpper . '(?=' . join(
                    '|',
                    [$rsBreak, $rsUpper . $rsMiscLower, '$']
                ) . ')',
                $rsUpper . '?' . $rsMiscLower . '+' . $rsOptContrLower,
                $rsUpper . '+' . $rsOptContrUpper,
                $rsOrdUpper,
                $rsOrdLower,
                $rsDigits,
                $rsEmoji,
            ]) . '/u';
        if ($pattern === null) {
            $hasUnicodeWord = preg_match($hasUnicodeWordRegex, $input);
            $pattern = $hasUnicodeWord ? $unicodeWords : $asciiWords;
        }
        $r = preg_match_all($pattern, $input, $matches, PREG_PATTERN_ORDER);
        if ($r === false) {
            throw new \RuntimeException('Regex exception');
        }

        return count($matches[0]) > 0 ? $matches[0] : [];
    }

    /**
     * Converts string, as space separated words, to lower case.
     *
     * @usage __::lowerCase('--Foo-Bar--');
     *        >> 'foo bar'
     *
     * @param string $input
     *
     * @return string
     */
    public static function lowerCase(string $input): string
    {
        $words = __::words(preg_replace("/['\x{2019}]/u", '', $input));

        return array_reduce(
            $words,
            function ($result, $word) use ($words) {
                $isFirst = __::first($words) === $word;

                return $result . (!$isFirst ? ' ' : '') . __::toLower($word);
            },
            ''
        );
    }
}
