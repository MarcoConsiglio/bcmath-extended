<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Traits;

use ArithmeticError;
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

    /**
     *  ╔══════════════╗
     *  ║DATA PROVIDERS║
     *  ╚══════════════╝
     */

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

    public static function powerModulo(): array
    {
        self::setUpFaker();
        return [
            'Integer power modulo' => self::getIntegerPowerModulo(),
            'String power modulo' => self::getStringPowerModulo(self::MAX),
            'BcMath\\Number power modulo' => self::getBcMathNumberPowerModulo(self::MAX),
            'BcMathExtended\\Number power modulo' => self::getBcMathExtendedNumerPowerModulo(self::MAX)
        ];
    }

    public static function squareRoot(): array
    {
        self::setUpFaker();
        return [
            'Integer square root' => self::getIntegerSquareRoot(),
            'String square root' => self::getStringSquareRoot(self::MAX),
            'BcMath\\Number square root' => self::getBcMathNumberSquareRoot(self::MAX),
            'BcMathExtended\\Number square root' => self::getBcMathExtendedNumberSquareRoot(self::MAX)
        ];
    }

    // public static function logarithm(): array
    // {
    //     self::setUpFaker();
    //     return [
    //         'Integer logarithm' => self::getIntegerLog(),
    //         'String logarithm' => self::getStringLog(self::MAX),
    //         'BcMath\\Number logarithm' => self::getBcMathNumberLog(self::MAX),
    //         'BcMathExtended\\Number logarithm' => self::getBcMathExtendedNumberLog(self::MAX)
    //     ];
    // }

    public static function rounding(): array
    {
        self::setUpFaker();
        return [
            'Integer rounding' => self::getIntegerRounding(),
            'String rounding' => self::getStringRounding(self::MAX),
            'BcMath\\Number rounding' => self::getBcMathNumberRounding(self::MAX),
            'BcMathExtended\\Number rounding' => self::getBCMathExtendedNumberRounding(self::MAX)
        ];
    }

    public static function floor(): array
    {
        self::setUpFaker();
        return [
            'Integer floor' => self::getIntegerFloor(),
            'String floor' => self::getStringFloor(self::MAX),
            'BcMath\\Number floor' => self::getBcMathNumberFloor(self::MAX),
            'BcMathExtended\\Number floor' => self::getBcMathExtendedNumberFloor(self::MAX)
        ];
    }

    public static function ceil(): array
    {
        self::setUpFaker();
        return [
            'Integer ceil' => self::getIntegerCeil(),
            'String ceil' => self::getStringCeil(self::MAX),
            'BcMath\\Number ceil' => self::getBcMathNumberCeil(self::MAX),
            'BcMathExtended\\Number ceil' => self::getBcMathExtendedNumberCeil(self::MAX)
        ];
    }

    public static function max(): array
    {
        self::setUpFaker();
        return [
            'Integer max' => self::getIntegerMax(),
            'String max' => self::getStringMax(self::MAX),
            'BcMath\\Number max' => self::getBcMathNumberMax(self::MAX),
            'BcMathExtended\\Number max' => self::getBcMathExtendedNumberMax(self::MAX)
        ];
    }

    public static function min(): array
    {
        self::setUpFaker();
        return [
            'Integer min' => self::getIntegerMin(),
            'String min' => self::getStringMin(self::MAX),
            'BcMath\\Number min' => self::getBcMathNumberMin(self::MAX),
            'BcMathExtended\\Number min' => self::getBcMathExtendedNumberMin(self::MAX)
        ];
    }

    public static function factorials(): array
    {
        self::setUpFaker();
        $max = 20;
        return [
            'Integer factorial' => self::getIntegerFactorial($max),
            'String factorial' => self::getStringFactorial($max),
            'BcMath\\Number factorial' => self::getBcMathNumberFactorial($max),
            'BcMathExtended\\Number factorial' => self::getBcMathExtendedNumberFactorial($max)
        ];   
    }

    public static function floats(): array
    {
        self::setUpFaker();
        return [
            'String float' => self::getStringFloat(self::MAX),
            'BcMath\\Number float' => self::getBcMathNumberFloat(self::MAX),
            'BcMathExtended\\Number float' => self::getBcMathExtendedNumberFloat(self::MAX)
        ];
    }

    /**
     *  ╔═════════════════╗
     *  ║INTEGER DATA SETS║
     *  ╚═════════════════╝
     */

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

    protected static function getIntegerPowerModulo(): array
    {
        return [
            $b = self::nonZeroRandomInteger(),
            $e = self::positiveNonZeroRandomInteger(
                max: $b > 0 ? intval(log(PHP_INT_MAX, $b)) : intval(log(PHP_INT_MAX, abs($b)))
            ),
            $m = self::nonZeroRandomInteger(),
            (int) (new Number(new BcMathNumber($b)->pow($e))->mod($m))->getParent()->value
        ];
    }

    protected static function getIntegerSquareRoot(): array
    {
        return [
            $n = self::randomInteger(max: intval(sqrt(PHP_INT_MAX))) ** 2,
            sqrt($n)
        ];
    }

    // protected static function getIntegerLog(): array
    // {
    //     $base = self::positiveNonZeroRandomInteger(min: 2);
    //     return [
    //         $arg = self::positiveRandomInteger(min: intval($base ** -PHP_INT_MAX), max: intval($base ** PHP_INT_MAX)),
    //         $base,
    //         round(log($arg, $base), 13, RoundingMode::HalfTowardsZero)
    //     ];
    // }

    protected static function getIntegerRounding(): array
    {
        $number = self::randomInteger();
        $digits = self::countIntDigits($number);
        $precision = self::positiveRandomInteger(max: $digits - 1);
        $rounded = new BcMathNumber($number)->round($precision, RoundingMode::HalfTowardsZero);
        return [
            $number,
            $precision,
            $rounded
        ];
    }

    protected static function getIntegerFloor(): array
    {
        return [
            $number = self::randomInteger(),
            $number
        ];
    }

    protected static function getIntegerCeil(): array
    {
        return [
            $number = self::randomInteger(),
            $number
        ];
    }

    protected static function getIntegerMax(): array
    {
        return self::getIntegerMinOrMax("max");
    }

    protected static function getIntegerMin(): array
    {
        return self::getIntegerMinOrMax("min");
    }

    protected static function getIntegerMinOrMax(string $min_or_max): array
    {
        if ($min_or_max != "min" && $min_or_max != "max") $min_or_max = "max";
        $count = self::positiveRandomInteger(2, 5);
        for ($i = 0; $i <= $count - 1; $i++) {
            $vars[$i] = self::randomInteger();
        }
        $result = $min_or_max($vars);
        return [
            $vars,
            $result
        ];        
    }

    protected static function getIntegerFactorial(int $max = 20): array
    {
        $n = self::positiveRandomInteger(max: $max);
        $factorial = self::factorial($n);
        return [
            $n,
            $factorial
        ];
    }

    /**
     *  ╔════════════════╗
     *  ║STRING DATA SETS║
     *  ╚════════════════╝
     */

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

    protected static function getStringPowerModulo(float $max = PHP_FLOAT_MAX): array
    {
        $b_string = self::string($b = self::nonZeroRandomFloat(max: $max));
        $e = self::nonZeroRandomInteger(
                max: $b > 0 ? intval(log(PHP_FLOAT_MAX, $b)) : intval(log(PHP_FLOAT_MAX, abs($b)))
            );
        $e_string = $e > 0 ? self::string($e - 1) : self::string($e + 1);
        $m_string = self::string($m = self::nonZeroRandomFloat(max: $max));
        $power = new BcMathNumber($b_string)->pow($e_string);
        $modulus = new BcMathNumber($m_string);
        $result = $power->sub($modulus->mul($power->div($modulus)->floor()));
        return [
            self::string($b_string),
            self::string($e_string),
            self::string($m_string),
            self::string($result->value)
        ];
    }

    protected static function getStringSquareRoot(float $max = PHP_FLOAT_MAX): array
    {
        $n = self::string(self::randomFloat(max: sqrt($max)) ** 2);
        $sqrt = new BcMathNumber($n)->sqrt()->value;
        return [
            $n,
            self::string($sqrt)
        ];
    }

    // protected static function getStringLog(float $max = PHP_FLOAT_MAX): array
    // {
    //     $base = round(self::positiveRandomFloat(max: $max), 13, RoundingMode::HalfTowardsZero);
    //     $arg = 
    //         $base > 1 ?
    //         self::positiveRandomFloat(max: $base ** log($max, $base)):
    //         self::positiveRandomFloat(min: $base ** log($max, $base), max: $max);
    //     $log = round(log($arg, $base), 13, RoundingMode::HalfTowardsZero);
    //     return [
    //         self::string($arg),
    //         self::string($base),
    //         self::string($log)
    //     ];
    // }

    protected static function getStringRounding(float $max = PHP_FLOAT_MAX): array
    {
        $number = self::string($float_number = self::randomFloat(max: $max));
        $decimal_digits = self::countDecimalPlaces($float_number);
        $integer_digits = self::countIntDigits(intval($float_number));
        if ($decimal_digits == 0) {
            $precision = self::$faker->randomElement([
                0, self::negativeRandomInteger(max: $integer_digits)
            ]);
        } else {
            $precision = self::$faker->randomElement([
                self::positiveRandomInteger(min: 1, max: $decimal_digits),
                self::$faker->randomElement([
                    0, self::negativeRandomInteger(max: self::countIntDigits(intval($float_number)))
                ])
            ]);
        }
        $rounded = new BcMathNumber($number)->round($precision, RoundingMode::HalfTowardsZero);
        return [
            $number,
            $precision,
            $rounded
        ];
    }

    protected static function getStringFloor(float $max = PHP_FLOAT_MAX): array
    {
        return [
            self::string($number = self::randomFloat(max: $max)),
            self::string(floor($number))
        ];
    }

    protected static function getStringCeil(float $max = PHP_FLOAT_MAX): array
    {
        return [
            self::string($number = self::randomFloat(max: $max)),
            self::string(ceil($number))
        ];
    }

    protected static function getStringMax(float $max_random = PHP_FLOAT_MAX): array
    {
        return self::getStringMinOrMax("max", $max_random);
    }

    protected static function getStringMin(float $max_random = PHP_FLOAT_MAX): array
    {
        return self::getStringMinOrMax("min", $max_random);
    }

    protected static function getStringMinOrMax(string $min_or_max, float $max_random = PHP_FLOAT_MAX): array
    {
        if ($min_or_max != "min" && $min_or_max != "max") $min_or_max = "max";
        $count = self::positiveRandomInteger(2, 5);
        for ($i = 0; $i <= $count - 1; $i ++) {
            $vars[$i] = self::randomFloat(max: $max_random);
        }
        $result = self::string($min_or_max($vars));
        foreach ($vars as $index => $var) {
            $vars[$index] = self::string($var);
        }
        return [
            $vars,
            $result
        ];
    }

    protected static function getStringFactorial(int $max = 20): array
    {
        [$n, $fact] = self::getIntegerFactorial($max);
        return [
            self::string($n),
            self::string($fact),
        ];
    }

    protected static function getStringFloat(float $max = PHP_FLOAT_MAX): array
    {
        return [
            self::string(self::randomFloatStrict(max: $max))
        ];
    }


    /**
     *  ╔═══════════════════════╗
     *  ║BCMath\Number DATA SETS║
     *  ╚═══════════════════════╝
     */

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

    protected static function getBcMathNumberPowerModulo(float $max = PHP_FLOAT_MAX): array
    {
        [$b, $e, $m, $pow_mod] = self::getStringPowerModulo($max);
        return [
            new BcMathNumber($b),
            new BcMathNumber($e),
            new BcMathNumber($m),
            new BcMathNumber($pow_mod)
        ];
    }

    protected static function getBcMathNumberSquareRoot(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $sqrt] = self::getStringSquareRoot($max);
        return [
            new BcMathNumber($n),
            new BcMathNumber($sqrt)
        ];       
    }

    // protected static function getBcMathNumberLog(float $max = PHP_FLOAT_MAX): array
    // {
    //     [$arg, $base, $log] = self::getStringLog($max);
    //     return [
    //         new BcMathNumber($arg),
    //         new BcMathNumber($base),
    //         new BcMathNumber($log),
    //     ];
    // }

    protected static function getBcMathNumberRounding(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $p, $rnd] = self::getStringRounding($max);
        return [
            new BcMathNumber($n),
            $p, // Precision must be integer!
            new BcMathNumber($rnd),
        ];
    }

    protected static function getBcMathNumberFloor(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $flr] = self::getStringFloor($max);
        return [
            new BcMathNumber($n),
            new BcMathNumber($flr)
        ];
    }

    protected static function getBcMathNumberCeil(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $ceil] = self::getStringCeil($max);
        return [
            new BcMathNumber($n),
            $ceil
        ];
    }

    protected static function getBcMathNumberMax(float $max_random = PHP_FLOAT_MAX): array
    {
        [$vars, $max] = self::getStringMax($max_random);
        foreach ($vars as $index => $var) {
            $vars[$index] = new BcMathNumber($var);
        }
        return [
            $vars,
            new BcMathNumber($max)
        ];
    }

    protected static function getBcMathNumberMin(float $max_random = PHP_FLOAT_MAX): array
    {
        [$vars, $min] = self::getStringMin($max_random);
        foreach ($vars as $index => $var) {
            $vars[$index] = new BcMathNumber($var);
        }
        return [
            $vars,
            new BcMathNumber($min)
        ];
    }

    protected static function getBcMathNumberFactorial(int $max = 20): array
    {
        [$n, $fact] = self::getIntegerFactorial($max);
        return [
            new BcMathNumber($n),
            new BcMathNumber($fact)
        ];
    }

    protected static function getBcMathNumberFloat(float $max = PHP_FLOAT_MAX): array
    {
        [$number] = self::getStringFloat(max: $max);
        return [
            new BcMathNumber($number)
        ];
    }

    /**
     *  ╔═══════════════════════════════╗
     *  ║BCMathExtended\Number DATA SETS║
     *  ╚═══════════════════════════════╝
     */

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

    protected static function getBcMathExtendedNumerPowerModulo(float $max = PHP_FLOAT_MAX): array
    {
        [$b, $e, $m, $pow_mod] = self::getBcMathNumberPowerModulo($max);
        return [
            new Number($b),
            new Number($e),
            new Number($m),
            new Number($pow_mod)
        ];
    }

    protected static function getBcMathExtendedNumberSquareRoot(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $sqrt] = self::getBcMathNumberSquareRoot($max);
        return [
            new Number($n),
            new Number($sqrt)
        ];       
    }

    // protected static function getBcMathExtendedNumberLog(float $max = PHP_FLOAT_MAX): array
    // {
    //     [$arg, $base, $log] = self::getBcMathNumberLog($max);
    //     return [
    //         new Number($arg),
    //         new Number($base),
    //         new Number($log),
    //     ];
    // }

    protected static function getBCMathExtendedNumberRounding(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $p, $rnd] = self::getBcMathNumberRounding($max);
        return [
            new Number($n),
            $p, // Precision must be integer!
            new Number($rnd)
        ];
    }

    protected static function getBcMathExtendedNumberFloor(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $flr] = self::getBcMathNumberFloor($max);
        return [
            new Number($n),
            new Number($flr)
        ];
    }

    protected static function getBcMathExtendedNumberCeil(float $max = PHP_FLOAT_MAX): array
    {
        [$n, $ceil] = self::getBcMathNumberCeil($max);
        return [
            new Number($n),
            $ceil
        ];
    }

    protected static function getBcMathExtendedNumberMax(float $max_random = PHP_FLOAT_MAX): array
    {
        [$vars, $max] = self::getBcMathNumberMax($max_random);
        foreach ($vars as $index => $var) {
            $vars[$index] = new Number($var);
        }
        $max = new Number($max);
        return [
            $vars,
            $max
        ];
    }

    protected static function getBcMathExtendedNumberMin(float $max_random = PHP_FLOAT_MAX): array
    {
        [$vars, $min] = self::getBcMathNumberMin($max_random);
        foreach ($vars as $index => $var) {
            $vars[$index] = new Number($var);
        }
        $min = new Number($min);
        return [
            $vars,
            $min
        ];
    }

    protected static function getBcMathExtendedNumberFactorial(int $max = 20): array
    {
        [$n, $fact] = self::getIntegerFactorial($max);
        return [
            new Number($n),
            new Number($fact)
        ];
    }

    protected static function getBcMathExtendedNumberFloat(float $max = PHP_FLOAT_MAX): array
    {
        [$number] = self::getBcMathNumberFloat($max);
        return [
            new Number($number)
        ];
    }

    /**
     * Format a $number to a numeric string.
     */
    protected static function string(int|float|string $number): string
    {
        if (self::isFloatString($number)) return self::trimTrailingZeros($number);
        else if (self::isIntString($number)) return $number;    
        if (is_int($number)) return self::formatInteger($number);
        return self::formatFloat($number);
    }

    /**
     * Return true if $number is a decimal numeric string, false otherwise.
     */
    private static function isFloatString(mixed $number): bool
    {
        return is_string($number) && strpos($number, '.');
    }

    /**
     * Return true if $number is an integer numeric string, false otherwise.
     */
    private static function isIntString(mixed $number): bool
    {
        return is_string($number) && ! strpos($number, '.');
    }

    /**
     * Remove trailing zeros from a numeric string.
     */
    protected static function trimTrailingZeros(string $number): string
    {
        $decimal_separator = strpos($number, '.');
        if($decimal_separator === false) { // It is integer number.
            return $number;
        } else return rtrim(rtrim($number, '0'), '.'); // It is a decimal number.
    }

    /**
     * Format an integer $number to string.
     */
    protected static function formatInteger(int $number): string
    {
        return sprintf("%d", $number);
    }

    /**
     * Format a float $number to string, also removing unneeded trailing zeros.
     */
    protected static function formatFloat(float $number): string
    {
        $decimal_places = self::countDecimalPlaces($number);
        $number = number_format($number, $decimal_places, thousands_separator: '');
        return self::trimTrailingZeros($number);
    }

    /**
     * Count the decimal digits of a decimal $number.
     */
    public static function countDecimalPlaces(float $number): int
    {
        for ($decimal_digits = 0; $number != round($number, $decimal_digits, RoundingMode::HalfTowardsZero); ++$decimal_digits);
        return $decimal_digits;
    }

    /**
     * Count the digits of an integer $number.
     */
    public static function countIntDigits(int $number): int
    {
        if (abs($number) == 0) return 1;
        if (abs($number) == 1) return 1;
        return intval(log(abs($number), 10) + 1);
    }

    /**
     * Count the decimal digits of a $number string.
     */
    public static function countStringDecimalPlaces(string $number): int
    {
        return strlen(substr(strrchr($number, "."), 1));
    }

    /**
     * Return the factorial of $n
     */
    protected static function factorial(int $n): int
    {
        if ($n < 0) throw new ArithmeticError("Cannot calculate $n!");
        $result = 1;
        for ($i = 1; $i <= $n; $i++) {
            $result *= $i;
        }
        return $result;
    }
}