<?php
declare(strict_types=1);

namespace MarcoConsiglio\BCMathExtended;

use DivisionByZeroError;
use RoundingMode;
use Stringable;
use ValueError;
use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Builders\FromBcMathNumber;
use MarcoConsiglio\BCMathExtended\Builders\FromFloat;
use MarcoConsiglio\BCMathExtended\Builders\FromInt;
use MarcoConsiglio\BCMathExtended\Builders\FromString;
// use MarcoConsiglio\BCMathExtended\Exceptions\IndeterminateFormError;
// use MarcoConsiglio\BCMathExtended\Exceptions\InfiniteError;
use MarcoConsiglio\BCMathExtended\Exceptions\NotANumberError;

class Number implements Stringable
{
    /**
     * The parent composite instance.
     */
    protected BCMathNumber $number;

    /**
     * The value of this instance.
     */
    public string $value {
        get {return $this->number->value;}
    }

    /**
     * The scale of this instance.
     * 
     * It represents the number of decimal places of this number.
     */
    public int $scale {
        get {return $this->number->scale;}
    }

    /**
     * Construct a Number.
     * 
     * @throws ValueError if $number is string and not a well-formed BCMath numeric string.
     * @see https://www.php.net/manual/en/bcmath-number.construct.php
     */
    public function __construct(string|int|float|BCMathNumber $number)
    {
        if (is_string($number)) $builder = new FromString($number);
        else if (is_int($number)) $builder = new FromInt($number);
        else if (is_float($number)) $builder = new FromFloat($number);
        else $builder = new FromBcMathNumber($number);
        $this->number = $builder->getResult();
    }

    /**
     * Return the parent BCMath/Number instance.
     */
    public function getParent(): BCMathNumber
    {
        return $this->number;
    }

    /**
     * Return true if $object is this (child) class.
     */
    public static function isChild(mixed $object): bool
    {
        return $object instanceof Number;
    }

    /**
     * Add $number to this instance.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.add.php
     */
    public function add(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        $number = $this->normalizeToParent($number);
        return new Number($this->number->add($number, $scale));
    }

    /**
     * Alias of add() method.
     */
    public function plus(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        return $this->add($number, $scale);
    }

    /**
     * Subtract $number from this instance.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.sub.php
     */
    public function subtract(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        $number = $this->normalizeToParent($number);
        return new Number($this->number->sub($number, $scale));
    }

    /**
     * Alias of subtract() method.
     */
    public function sub(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        return $this->subtract($number, $scale);
    }

    /**
     * Multiply this instance times $number.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.mul.php
     */
    public function multiply(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        $number = $this->normalizeToParent($number);
        return new Number($this->number->mul($number, $scale));
    }

    /**
     * Alias of multiply() method.
     */
    public function mul(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        return $this->multiply($number, $scale);
    }

    /**
     * Divide this instance by $number.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.div.php
     * @throws DivisionByZeroError if $number is 0.
     */
    public function divide(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        $number = $this->normalizeToParent($number);
        return new Number($this->number->div($number, $scale));
    }

    /**
     * Alias of divide() method.
     */
    public function div(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        return $this->divide($number, $scale);
    }

    /**
     * Return the remainder of the division of this instance by $number.
     * 
     * This method do not call the parent method mod().
     */
    public function modulo(Number|BcMathNumber|string|int $modulus, int|null $scale = null): Number
    {
        $modulus = $this->normalizeToParent($modulus);
        // $number - $modulus * floor($number / $modulus).
        return new Number($this->number->sub($modulus->mul($this->number->div($modulus, $scale)->floor())));
    }

    /**
     * Alias of modulo() method.
     */
    public function mod(Number|BcMathNumber|string|int $modulus, int|null $scale = null): Number
    {
        return $this->modulo($modulus, $scale);
    }

    /**
     * Return the quotient and remainder of this instance divided by $divisor.
     * 
     * This method do not call the parent method mod().
     * 
     * @return Number[] The first is the quotient of the division, the second 
     * is the remainder of the division.
     */
    public function quotientAndRemainder(Number|BcMathNumber|string|int $divisor, int|null $scale = null): array
    {
        $divisor = $this->normalizeToParent($divisor);
        return [$this->divide($divisor)->floor(), $this->modulo($divisor)];
    }

    /**
     * Alias of quotientAndRemainder() method.
     * 
     * @return Number[]
     */
    public function divmod(Number|BcMathNumber|string|int $divisor, int|null $scale = null): array
    {
        return $this->quotientAndRemainder($divisor, $scale);
    }

    /**
     * Raise this instance to $exponent.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.pow.php
     */
    public function power(Number|BcMathNumber|string|int $exponent, int|null $scale = null): Number
    {
        $exponent = $this->normalizeToParent($exponent);
        return new Number($this->number->pow($exponent, $scale));
    }

    /**
     * Alias of power() method.
     */
    public function pow(Number|BcMathNumber|string|int $exponent, int|null $scale = null): Number
    {
        return $this->power($exponent, $scale);
    }

    /**
     * Raise this instance to $exponent and reduce the result by $modulus.
     * 
     * In other words, this method perform ($this ** $exponent) % $modulus.
     * This method do not call the parent method mod().
     */
    public function powerModulo(Number|BcMathNumber|string|int $exponent, Number|BcMathNumber|string|int $modulus, int|null $scale = null): Number
    {
        $exponent = $this->normalizeToParent($exponent);
        $modulus = $this->normalizeToParent($modulus);
        return new Number($this->number)->power($exponent)->modulo($modulus, $scale);
    }

    /**
     * Alias of powerModulo() method.
     */
    public function powmod(Number|BcMathNumber|string|int $exponent, Number|BcMathNumber|string|int $modulus, int|null $scale = null): Number
    {
        return $this->powerModulo($exponent, $modulus, $scale);
    }

    /**
     * Return the square root of this instance.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.sqrt.php
     */
    public function squareRoot(int|null $scale = null): Number
    {
        return new Number($this->number->sqrt($scale));
    }

    /**
     * Alias of squareRoot() method.
     */
    public function sqrt(int|null $scale = null): Number
    {
        return $this->squareRoot($scale);
    }

    // /**
    //  * Perform the logarithm of this instance in base $base.
    //  * 
    //  * @param int|null $scale If set to null the value will be $this->getParent()->scale.
    //  */
    // public function log(int|string|BCMathNumber|Number $base, int|null $scale = null): Number
    // {
    //     $base = $this->normalizeToParent($base);
    //     $this->checkNotANumber($base);
    //     $this->checkIndeterminateForm($base);
    //     $this->checkInfinite($base);
    //     $result = log((float) $this->number->value, (float) $base->value);
    //     if ($scale == null) $scale = $this->number->scale;
    //     return new Number(sprintf("%.{$scale}f", $result));
    // }

    // /**
    //  * Check if the result of the logarithm operation is not a number.
    //  */
    // protected function checkNotANumber(BCMathNumber $base): void
    // {
    //     if ($this->isNegativeNumber($this->number)) throw throw new NotANumberError("log($this->number, $base)");
    //     if ($this->isArgOneAndBaseNotOne($this->number, $base)) throw new NotANumberError("log($this->number, $base)");
    // }

    // /**
    //  * Check if the logarithm operation is an indeterminate form.
    //  */
    // protected function checkIndeterminateForm(BCMathNumber $base): void
    // {
    //     if ($this->isNegativeNumber($base)) throw new IndeterminateFormError("log($this->number, $base)");
    //     if ($this->isArgumentAndBaseEqualZero($this->number, $base)) throw new IndeterminateFormError("log($this->number, $base)");
    //     if ($this->isArgOneAndBaseOne($this->number, $base)) throw new IndeterminateFormError("log($this->number, $base)");
    // }

    // /**
    //  * Check if the result of the logarithm operation is infinite.
    //  */
    // protected function checkInfinite(BCMathNumber $base): void
    // {
    //     if ($this->isArgZeroAndBaseNotZero($this->number, $base)) throw new InfiniteError("log($this->number, $base)");
    // }

    // private function isArgOneAndBaseOne(BCMathNumber $argument, BCMathNumber $base): bool
    // {
    //     return $this->isOne($argument) && $this->isOne($base);
    // }

    // private function isArgOneAndBaseNotOne(BCMathNumber $argument, BCMathNumber $base): bool
    // {
    //     return $this->isOne($argument) && $this->isNotOne($base);
    // }

    // private function isArgZeroAndBaseNotZero(BCMathNumber $argument, BCMathNumber $base): bool
    // {
    //     return $this->isZero($argument) && $this->isNotZero($base);
    // }

    // private function isOne(BCMathNumber $number): bool
    // {
    //     return $number == 1;
    // }

    // private function isZero(BCMathNumber $number): bool
    // {
    //     return $number == 0;
    // }

    // private function isNotOne(BCMathNumber $number): bool
    // {
    //     return $number != 1;
    // }

    // private function isNotZero(BCMathNumber $number): bool
    // {
    //     return $number != 0;
    // }

    // private function isNegativeNumber(BCMathNumber $base): bool
    // {
    //     return $base < 0;
    // }

    // private function isArgumentAndBaseEqualZero(BCMathNumber $argument, BCMathNumber $base): bool
    // {
    //     return $argument == 0 && $base == 0;
    // }

    /**
     * Round this instance to $precision digits.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.round.php
     * @param RoundingMode $mode Warning! The default rounding mode is set to 
     * RoundingMode::HalfTowardsZero, instead of the one in BCMath which is 
     * RoundingMode::HalfAwayFromZero.
     */
    public function round(int $precision = 0, RoundingMode $mode = RoundingMode::HalfTowardsZero): Number
    {
        return new Number($this->number->round($precision, $mode));
    }

    /**
     * Return the next lower integer of this instance.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.floor.php
     */
    public function floor(): Number
    {
        return new Number($this->number->floor());
    }

    /**
     * Return the next higher integer of this instance.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.ceil.php
     */
    public function ceil(): Number
    {
        return new Number($this->number->ceil());
    }

    /**
     * Return the greatest number in $values.
     */
    public static function max(mixed ...$values): Number
    {
        $values = self::normalizeArrayToParent($values);
        return new Number(max(...$values));
    }

    /**
     * Return the lesser number in $values.
     */
    public static function min(mixed ...$values): Number
    {
        $values = self::normalizeArrayToParent($values);
        return new Number(min($values));
    }

    /**
     * Return the factorial of $this number.
     * 
     * @throws NotANumber if $this->number is a decimal number or a negative number.
     */
    public function factorial(): Number
    {
        if ($this->isFloat()) throw new NotANumberError("$this->number!");
        if ($this->number < 0) throw new NotANumberError("$this->number!");
        return new Number($this->f((int) $this->number->value));
    }

    /**
     * Alias of factorial() method.
     */
    public function fact(): Number
    {
        return $this->factorial();
    }

    /**
     * Recursive alogorithm that calcs the factorial of $n.
     */
    private function f(int $n): int 
    {
        if ($n == 0) return 1;
        return $n * $this->f($n - 1);
    }

    /**
     * Return the absolute value of $this->number.
     */
    public function abs(): Number
    {
        if ($this->isNegative()) {
            $number = substr($this->number->value, 1);
            return new Number($number);
        }
        else return $this;
    }

    /**
     * Return true if $this->number is positive, false otherwise.
     */
    public function isNegative(): bool
    {
        return $this->number < 0;
    }

    /**
     * Return true if $this->number is negative, false otherwise.
     */
    public function isPositive(): bool
    {
        return $this->number >= 0;
    }

    /**
     * Return true if $this number is a decimal number, false otherwise.
     */
    public function isFloat(): bool
    {
        return str_contains($this->number->value, '.');
    }

    /**
     * Return true if $this number is a integer number, false otherwise.
     */
    public function isInt(): bool
    {
        return ! $this->isFloat();
    }

    /**
     * Return true if this instance equals $number, false otherwise.
     */
    public function isEqual(int|string|BCMathNumber|Number $number): bool
    {
        $number = $this->normalizeToParent($number);
        return $this->number == $number;
    }

    /**
     * Alias of isEqual() method.
     */
    public function eq(int|string|BCMathNumber|Number $number): bool
    {
        return $this->isEqual($number);
    }

    /**
     * Return true if this instance is different than $number, false otherwise.
     */
    public function isDifferent(int|string|BCMathNumber|Number $number): bool
    {
        $number = $this->normalizeToParent($number);
        return $this->number != $number;
    }

    /**
     * Alias of isDifferent() method.
     */
    public function not(int|string|BCMathNumber|Number $number): bool
    {
        return $this->isDifferent($number);
    }

    /**
     * Return true if this instance is greater than $number, false otherwise.
     */
    public function isGreaterThan(int|string|BCMathNumber|Number $number): bool
    {
        $number = $this->normalizeToParent($number);
        return $this->number > $number;
    }

    /**
     * Alias of isGreaterThan() method.
     */
    public function gt(int|string|BCMathNumber|Number $number): bool
    {
        return $this->isGreaterThan($number);
    }

    /**
     * Return true if this instance is greater than or equal to $number, false
     * otherwise.
     */
    public function isGreaterThanOrEqual(int|string|BCMathNumber|Number $number): bool
    {
        $number = $this->normalizeToParent($number); 
        return $this->number >= $number;
    }

    /**
     * Alias of isGreaterThanOrEqual() method.
     */
    public function gte(int|string|BCMathNumber|Number $number): bool
    {
        return $this->isGreaterThanOrEqual($number);
    }

    /**
     * Return true if this instance is less than $number, false otherwise.
     */
    public function isLessThan(int|string|BCMathNumber|Number $number): bool
    {
        $number = $this->normalizeToParent($number); 
        return $this->number < $number;
    }

    /**
     * Alias of isLessThan() method.
     */
    public function lt(int|string|BCMathNumber|Number $number): bool
    {
        return $this->isLessThan($number);
    }

    /**
     * Return true if this instance is lesse than or equal to $number, false 
     * otherwise.
     */
    public function isLessThanOrEqual(int|string|BCMathNumber|Number $number): bool
    {
        $number = $this->normalizeToParent($number);
        return $this->number <= $number;
    }

    /**
     * Alias of isLessThanOrEqual() method.
     */
    public function lte(int|string|BCMathNumber|Number $number): bool
    {
        return $this->isLessThanOrEqual($number);
    }

    /**
     * Transform $number into a BcMath\Number instance.
     */
    protected static function normalizeToParent(int|float|string|BCMathNumber|Number $number): BCMathNumber
    {
        if (self::isChild($number)) return $number->getParent();
        if (is_int($number)) return new BCMathNumber($number);
        if (is_float($number)) return new BCMathNumber(Number::string($number));
        if (is_string($number)) return new BCMathNumber($number);  
        return $number; // Parent instance.
    }

    /**
     * Transform $numbers into an array of BcMath\Number instances.
     * 
     * @param int[]|string[]|BcMathNumber[]|Number[]
     * @return BcMathNumber[]
     * @throws TypError if at least one element of $numbers is not of type
     * int, string, BcMath\Number or BcMathExtended\Number.
     */
    protected static function normalizeArrayToParent(array $numbers): array
    {
        foreach ($numbers as $index => $number) {
            $numbers[$index] = self::normalizeToParent($number);
        }
        return $numbers;
    }

    /**
     * Cast this instance to string.
     */
    public function __toString(): string
    {
        return $this->number->value;
    }

    /**
     * Format a $number to a numeric string.
     */
    public static function string(int|float|string $number): string
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
    private static function trimTrailingZeros(string $number): string
    {
        $decimal_separator = strpos($number, '.');
        if($decimal_separator === false) { // It is integer number.
            return $number;
        } else return rtrim(rtrim($number, '0'), '.'); // It is a decimal number.
    }

    /**
     * Format an integer $number to string.
     */
    private static function formatInteger(int $number): string
    {
        return sprintf("%d", $number);
    }

    /**
     * Format a float $number to string, also removing unneeded trailing zeros.
     */
    private static function formatFloat(float $number): string
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
}
