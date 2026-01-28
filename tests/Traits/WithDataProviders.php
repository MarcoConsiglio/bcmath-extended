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
    protected const int MAX = 1_000_000;

    public static function addition(): array
    {
        self::setUpFaker();
        return [
            'Integer addends' => self::getIntegerAddends(),
            'String addends' => self::getStringAddends(self::MAX),
            "BcMath\\Number addends" => self::getBcMathNumberAddends(self::MAX),
            "BcMathExtendend\\Number addends" => self::getBcMathExtendedNumberAddends(self::MAX)
        ];
    }

    public static function subtraction(): array
    {
        self::setUpFaker();
        return [
            'Integer minuends' => self::getIntegerMinuends(),
            'String minuends' => self::getStringMinuends(self::MAX),
            "BcMath\\Number minuends" => self::getBcMathNumberMinuends(self::MAX),
            "BcMathExtendend\\Number minuends" => self::getBcMathExtendedNumberMinuends(self::MAX)
        ];
    }

    public static function multiplication(): array
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

    public static function remainders(): array
    {
        self::setUpFaker();
        return [
            'Integer modulus' => self::getIntegerModulus(),
            'String modulus' => self::getStringModulus(self::MAX),
            'BcMath\\Number modulus' => self::getBcMathNumberModulus(self::MAX),
            'BcMathExtended\\Number modulus' => self::getBcMathExtendedNumberModulus(self::MAX)
        ];
    }

    public static function quotientAndRemainders(): array
    {
        self::setUpFaker();
        return [
            'Integer dividends' => self::getIntegerQuotientRemainder(),
            'String dividends' => self::getStringQuotientRemainder(self::MAX),
            'BcMath\\Number dividends' => self::getBcMathNumberQuotientRemainder(self::MAX),
            'BcMathExtended\\Number dividends' => self::getBcMathExtendedQuotientRemainder(self::MAX)
        ];
    }

    public static function power(): array
    {
        self::setUpFaker();
        return [
            'Integer power' => self::getIntegerPower(),
            'String power' => self::getStringPower(self::MAX),
            'BcMath\\Number power' => self::getBcMathNumberPower(self::MAX),
            'BcMathExtended\\Number power' => self::getBcMathExtendedNumberPower(self::MAX)
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

    protected static function getIntegerModulus(): array
    {
        return [
            $a = self::nonZeroRandomInteger(max: self::MAX),
            $b = self::$faker->randomElement(Divisors::of($a)),
            $a - $b * intval(floor($a / $b))
        ];
    }

    protected static function getIntegerQuotientRemainder(): array
    {
        return [
            $a = self::randomInteger(),
            $b = self::nonZeroRandomInteger(max: abs(intval($a / PHP_INT_MAX) + 1)),
            intval($a / $b),
            $a - $b * intval($a / $b)
        ];
    }

    protected static function getIntegerPower(): array
    {
        return [
            $b = self::nonZeroRandomInteger(),
            $e = self::positiveNonZeroRandomInteger(
                max: $b > 0 ? intval(log(PHP_INT_MAX, $b)) : intval(log(PHP_INT_MAX, abs($b)))
            ),
            $b ** $e
        ];
    }

    protected static function getStringAddends(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::randomFloat(max: $max)),
            $b_string = self::string(self::randomFloat(
                max: $a >= 0 ? $max - $a : abs(-$max - $a)
            )),
            self::string(new BcMathNumber($a_string)->add($b_string))
        ];
    }

    protected static function getStringMinuends(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::randomFloat(max: $max)),
            $b_string = self::string(self::randomFloat(
                max: $a >= 0 ? abs(-$max + $a) : $max + $a
            )),
            self::string(new BcMathNumber($a_string)->sub($b_string))
        ];
    }

    protected static function getStringFactors(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::randomFloat(max: $max)),
            $b_string = self::string(self::randomFloat(max: abs($max / $a))),
            self::string(new BcMathNumber($a_string)->mul($b_string))
        ];
    }

    protected static function getStringDividends(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::nonZeroRandomFloat(max: $max)),
            $b_string = self::string(self::nonZeroRandomFloat(max: abs($a / $max))),
            self::string(new BcMathNumber($a_string)->div($b_string))
        ];
    }

    protected static function getStringModulus(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string(self::randomFloat(max: $max)),
            $b_string = self::string(self::nonZeroRandomFloat(max: $max)),
            new BcMathNumber($a_string)->sub(new BcMathNumber($a_string)->div($b_string)->floor()->mul($b_string))
        ];
    }

    protected static function getStringQuotientRemainder(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $a_string = self::string($a = self::nonZeroRandomFloat(max: $max)),
            $b_string = self::string(self::nonZeroRandomFloat(max: abs($a / $max))),
            self::string(new BcMathNumber($a_string)->div($b_string)->floor()->value),
            // $a - $b * floor($a / $b)
            new BcMathNumber($a_string)->sub(
                (new BcMathNumber($b_string)->mul(
                    (new BcMathNumber($a_string)->div($b_string)->floor())->value
                ))->value
            )
        ];
    }

    protected static function getStringPower(float $max = PHP_FLOAT_MAX): array
    {
        return [
            $b_string = self::string($b = self::nonZeroRandomFloat(max: $max)),
            $e_string = self::string(self::randomInteger(
                max: $b > 0 ? intval(log(PHP_INT_MAX, $b)) : intval(log(PHP_INT_MAX, abs($b)))
            )),
            self::string(new BcMathNumber($b_string)->pow($e_string)->value)
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

    protected static function getBcMathNumberModulus(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $rem] = self::getStringModulus($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($rem)
        ];
    }

    protected static function getBcMathNumberQuotientRemainder(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $quot, $rem] = self::getStringQuotientRemainder($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($quot),
            new BcMathNumber($rem)
        ];
    }

    protected static function getBcMathNumberPower(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $pow] = self::getStringPower($max);
        return [
            new BcMathNumber($a),
            new BcMathNumber($b),
            new BcMathNumber($pow)
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
            new Number($a),
            new Number($b),
            new Number($prod)
        ];
    }

    protected static function getBcMathExtendedNumberDividends(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $quot] = self::getBcMathNumberDividends($max);
        return [
            new Number($a),
            new Number($b),
            new Number($quot)
        ];
    }

    protected static function getBcMathExtendedNumberModulus(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $rem] = self::getBcMathNumberModulus($max);
        return [
            new Number($a),
            new Number($b),
            new Number($rem)
        ];
    }

    protected static function getBcMathExtendedQuotientRemainder(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $quot, $rem] = self::getBcMathNumberQuotientRemainder($max);
        return [
            new Number($a),
            new Number($b),
            new Number($quot),
            new Number($rem)
        ];
    }

    protected static function getBcMathExtendedNumberPower(float $max = PHP_FLOAT_MAX): array
    {
        [$a, $b, $pow] = self::getBcMathNumberPower($max);
        return [
            new Number($a),
            new Number($b),
            new Number($pow)
        ];    
    }

    protected static function string(float|string $number): string
    {
        if (is_string($number) && strpos($number, '.')) return self::trimTrailingZeros($number);
        else if (is_string($number)) return $number;    
        $decimal_places = self::countDecimalPlaces($number);
        if ($decimal_places == 0) return self::formatInteger($number);
        return self::formatNumber($number, $decimal_places);
    }

    protected static function trimTrailingZeros(string $number): string
    {
        return rtrim($number, "0");
    }

    protected static function formatInteger(float $number): string
    {
        return number_format($number, 0, '', '');
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