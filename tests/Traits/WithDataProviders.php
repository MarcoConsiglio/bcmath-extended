<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Traits;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Number;
use RoundingMode;

trait WithDataProviders
{
    use WithFaker;

    public static function addends(): array
    {
        // WARNING! Large float type numbers makes unrecoverable
        // rounding errors!
        $max = 1_000_000.0;
        self::setUpFaker();
        return [
            'Integer addends' => self::getIntegerAddends(),
            'String addends' => self::getStringAddends($max),
            "BcMath\\Number addends" => self::getBcMathNumberAddends($max),
            "BcMathExtendend\\Number addends" => self::getBcMathExtendedNumberAddends($max)
        ];
    }

    protected static function getIntegerAddends(): array
    {
        return [
            $a = self::randomInteger(), 
            $b = self::randomInteger(
                min: $a >= 0 ? abs(-PHP_INT_MAX + $a) : abs(-PHP_INT_MAX - $a),
                max: $a >= 0 ? PHP_INT_MAX - $a : PHP_INT_MAX + $a
            ),
            $a + $b
        ];
    }

    protected static function getStringAddends(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::randomFloat(max: $max)),
            $b_string = self::string($b = self::randomFloat(
                min: 0,
                max: $a >= 0 ? $max - $a : abs(-$max - $a)
            )),
            self::string(bcadd($a_string, $b_string, self::countDecimalPlaces($a + $b)))
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

    protected static function getBcMathExtendedNumberAddends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $sum] = self::getBcMathNumberAddends($max);
        return [
            new Number($a),
            new Number($b),
            new Number($sum)
        ];
    }

    protected static function string(float $number): string
    {
        $decimal_places = self::countDecimalPlaces($number);
        if ($decimal_places == 0) return sprintf("%d", $number);
        // return number_format($number, $decimal_places, thousands_separator: '');
        return rtrim(number_format($number, $decimal_places, thousands_separator: ''), "0");
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