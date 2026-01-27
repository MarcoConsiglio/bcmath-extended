<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Traits;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\BCMathExtended\Tests\Divisors;
use MarcoConsiglio\BCMathExtended\Tests\DivisorsPrime;
use RoundingMode;

trait WithDataProviders
{
    use WithFaker;

    /**
     * WARNING! Large float type numbers makes unrecoverable rounding errors!
     * Use this constant to not reach huge numbers.
     */
    protected const float MAX = 1_000_000.0;

    public static function addends(): array
    {
        self::setUpFaker();
        return [
            'Integer addends' => self::getIntegerAddends(),
            'String addends' => self::getStringAddends(self::MAX),
            "BcMath\\Number addends" => self::getBcMathNumberAddends(self::MAX),
            "BcMathExtendend\\Number addends" => self::getBcMathExtendedNumberAddends(self::MAX)
        ];
    }

    public static function minuends(): array
    {
        self::setUpFaker();
        return [
            'Integer minuends' => self::getIntegerMinuends(),
            'String minuends' => self::getStringMinuends(self::MAX),
            "BcMath\\Number minuends" => self::getBcMathNumberMinuends(self::MAX),
            "BcMathExtendend\\Number minuends" => self::getBcMathExtendedNumberMinuends(self::MAX)
        ];
    }

    public static function factors(): array
    {
        self::setUpFaker();
        return [
            'Integer factors' => self::getIntegerFactors(),
            'String factors' => self::getStringFactors(self::MAX),
            "BcMath\\Number factors" => self::getBcMathNumberFactors(self::MAX),
            "BcMathExtendend\\Number factor" => self::getBcMathExtendedNumberFactors(self::MAX)
        ];
    }

    public static function dividends(): array
    {
        self::setUpFaker();
        return [
            'Integer dividends' => self::getIntegerDividends(),
            'String dividends' => self::getStringDividends(self::MAX),
            "BcMath\\Number dividends" => self::getBcMathNumberDividends(self::MAX),
            "BcMathExtended\\Number factor" => self::getBcMathExtendedNumberDividends(self::MAX)
        ];
    }

    protected static function getIntegerAddends(): array
    {
        return [
            $a = self::randomInteger(), 
            $b = self::randomInteger(
                max: $a >= 0 ? PHP_INT_MAX - $a : abs(-PHP_INT_MAX - $a)
            ),
            $a + $b
        ];
    }

    protected static function getIntegerMinuends(): array
    {
        return [
            $a = self::randomInteger(),
            $b = self::randomInteger(
                max: $a >= 0 ? PHP_INT_MAX - $a : abs(-PHP_INT_MAX - $a)
            ),
            $a - $b
        ];
    }

    protected static function getIntegerFactors(): array
    {
        return [
            $a = self::nonZeroRandomInteger(),
            $b = self::randomInteger(
                max: intval(PHP_INT_MAX / $a)
            ),
            $a * $b
        ];
    }

    protected static function getIntegerDividends(): array
    {
        return [
            $a = self::nonZeroRandomInteger(max: 1_000_000),
            $b = self::$faker->randomElement(Divisors::of($a)),
            $a / $b
        ];
    }

    protected static function getStringAddends(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::randomFloat(max: $max)),
            $b_string = self::string($b = self::randomFloat(
                max: $a >= 0 ? $max - $a : abs(-$max - $a)
            )),
            self::string(new BcMathNumber($a_string)->add($b_string))
        ];
    }

    protected static function getStringMinuends(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::randomFloat(max: $max)),
            $b_string = self::string($b = self::randomFloat(
                max: $a >= 0 ? abs(-$max + $a) : $max + $a
            )),
            self::string(new BcMathNumber($a_string)->sub($b_string))
        ];
    }

    protected static function getStringFactors(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::randomFloat(max: $max)),
            $b_string = self::string($b = self::randomFloat(max: abs($max / $a))),
            self::string(new BcMathNumber($a_string)->mul($b_string))
        ];
    }

    protected static function getStringDividends(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::nonZeroRandomFloat(max: $max)),
            $b_string = self::string($b = self::nonZeroRandomFloat(max: abs($a / $max))),
            self::string(new BcMathNumber($a_string)->div($b_string))
        ];
    }

    protected static function getBcMathNumberAddends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $sum] = self::getStringAddends($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($sum),
        ];
    }

    protected static function getBcMathNumberMinuends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $diff] = self::getStringMinuends($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($diff)
        ];
    }

    protected static function getBcMathNumberFactors(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $prod] = self::getStringFactors($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($prod)
        ];
    }

    protected static function getBcMathNumberDividends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $quot] = self::getStringDividends($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($quot)
        ];
    }

    protected static function getBcMathExtendedNumberAddends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $sum] = self::getBcMathNumberAddends($max);
        return [
            new Number($a),
            new Number($b),
            new Number($sum)
        ];
    }

    protected static function getBcMathExtendedNumberMinuends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $diff] = self::getBcMathNumberMinuends($max);
        return [
            new Number($a),
            new Number($b),
            new Number($diff)
        ];
    }

    protected static function getBcMathExtendedNumberFactors(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $prod] = self::getBcMathNumberFactors($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($prod)
        ];
    }

    protected static function getBcMathExtendedNumberDividends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $quot] = self::getBcMathNumberDividends($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($quot)
        ];
    }

    protected static function string(float|string $number): string
    {
        if (self::isStringFloat($number)) return self::trimTrailingZeros($number);
        else if (is_string($number)) return $number;    
        $decimal_places = self::countDecimalPlaces($number);
        if ($decimal_places == 0) return self::formatInteger((int) $number);
        return self::formatNumber($number, $decimal_places);
    }

    protected static function isStringFloat(string $number): bool
    {
        return is_string($number) && strpos($number, '.');
    }

    protected static function trimTrailingZeros(string $number): string
    {
        return rtrim($number, "0");
    }

    protected static function formatInteger(int $number): string
    {
        return sprintf("%d", $number);
    }

    protected static function formatNumber(int|float $number, int $decimal_places): string
    {
        if (is_int($number)) return self::formatInteger($number);
        return self::trimTrailingZeros(
            number_format($number, $decimal_places, thousands_separator: '')
        );
    }

    /**
     * Count the decimal digits of a decimal number.
     */
    public static function countDecimalPlaces(float $number): int
    {
        for ($decimal_digits = 0; $number != round($number, $decimal_digits, RoundingMode::HalfTowardsZero); ++$decimal_digits);
        return $decimal_digits;
    }

    public static function countStringDecimalPlaces(string $number): int
    {
        return strlen(substr(strrchr($number, "."), 1));
    }
}