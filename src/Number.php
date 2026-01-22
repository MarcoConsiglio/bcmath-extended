<?php
declare(strict_types=1);

namespace MarcoConsiglio\BCMathExtended;

use Closure;
use InvalidArgumentException;
use RoundingMode;
use ValueError;
use BcMath\Number as BCMathNumber;
use Stringable;

class Number implements Stringable
{
    public const int COMPARE_EQUAL = 0;
    public const int COMPARE_LEFT_GRATER = 1;
    public const int COMPARE_RIGHT_GRATER = -1;

    protected const int DEFAULT_SCALE = 100;

    protected const int MAX_BASE = 256;

    protected const string BIT_OPERATOR_AND = 'and';
    protected const string BIT_OPERATOR_OR = 'or';
    protected const string BIT_OPERATOR_XOR = 'xor';

    protected static bool $trimTrailingZeroes = true;
    private static ?int $currentScale = null;

    protected BCMathNumber $number;

    /**
     * Construct a Number.
     * 
     * @throws ValueError if $number is string and not a well-formed BCMath numeric string.
     * @see https://www.php.net/manual/en/bcmath-number.construct.php
     */
    public function __construct(string|int|BCMathNumber $number)
    {
        if ($number instanceof BCMathNumber) $this->number = $number;
        else $this->number = new BCMathNumber($number);
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
        if ($this->isChild($number)) $number = $number->getParent();
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
        if ($this->isChild($number)) $number = $number->getParent();
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
        if ($this->isChild($number)) $number = $number->getParent();
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
     */
    public function divide(Number|BcMathNumber|string|int $number, int|null $scale = null): Number
    {
        if ($this->isChild($number)) $number = $number->getParent();
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
     * @see https://www.php.net/manual/en/bcmath-number.mod.php
     */
    public function modulo(Number|BcMathNumber|string|int $modulus, int|null $scale = null): Number
    {
        // $number - $modulus * floor($number / $modulus).
        if ($scale !== null) bcscale($scale);
        if ($this->isChild($modulus)) $modulus = $modulus->getParent();
        return new Number($this->number->sub($modulus->mul($this->number->div($modulus)->floor())));
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
     * @see https://www.php.net/manual/en/bcmath-number.divmod.php
     * @return Number[] The first is the quotient of the division, the second 
     * is the remainder of the division.
     */
    public function quotientAndRemainder(Number|BcMathNumber|string|int $divisor, int|null $scale = null): array
    {
        if ($this->isChild($divisor)) $divisor = $divisor->getParent();
        [$quotient, $remainder] = $this->number->divmod($divisor, $scale);
        return [new Number($quotient), new Number($remainder)];
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
        if ($this->isChild($exponent)) $exponent = $exponent->getParent();
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
     * Raise this instance to $exponent and reduce the result to by $modulus.
     * 
     * In other words, this method perform ($this ** $exponent) % $modulus.
     * 
     * @see https://www.php.net/manual/en/bcmath-number.powmod.php
     */
    public function powerModulo(Number|BcMathNumber|string|int $exponent, Number|BcMathNumber|string|int $modulus, int|null $scale = null): Number
    {
        if ($exponent instanceof Number) $exponent = $exponent->getParent();
        if ($modulus instanceof Number) $modulus = $modulus->getParent();
        return new Number($this->number->powmod($exponent, $modulus, $scale));
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
     * Return the number of decimal places of $number.
     */
    public static function getDecimalsLength(int|string|BCMathNumber|Number $number): int
    {
        if (is_string($number)) {
            if (static::isFloat($number)) {
                return strlen(strrchr($number, ".")) - 1;
            }
            return 0;
        }
        if (is_int($number)) return 0;
        if ($number instanceof BCMathNumber) return self::getDecimalsLength($number->value);
        return self::getDecimalsLength($number->getParent()->value);
    }

    /**
     * Return true if $number is a float number.
     */
    protected static function isFloat(int|string|BCMathNumber|Number $number): bool
    {
        return str_contains((string) $number, '.');
    }

    public static function getScale(): int
    {
        return bcscale();
    }

    protected static function parseToNumber(int|string|BCMathNumber $number): BCMathNumber
    {
        if ($number instanceof BCMathNumber) {
            return $number;
        }

        if (is_int($number)) {
            return new BCMathNumber($number);
        }

        $number = str_replace(
            '+',
            '',
            (string)filter_var(
                $number,
                FILTER_SANITIZE_NUMBER_FLOAT,
                FILTER_FLAG_ALLOW_FRACTION
            )
        );
        if ($number === '-0' || !is_numeric($number)) {
            $number = 0;
        }
        return new BCMathNumber($number);
    }

    protected static function formatTrailingZeroes(BCMathNumber $number): BCMathNumber
    {
        if (self::$trimTrailingZeroes) {
            return static::trimTrailingZeroes($number);
        }

        return $number;
    }

    protected static function trimTrailingZeroes(int|string|BCMathNumber $number): BCMathNumber
    {
        $number = (string)$number;

        if (static::isFloat($number)) {
            $number = rtrim($number, '0');
        }

        $number = rtrim($number, '.') ?: '0';

        return new BCMathNumber($number);
    }

    public static function log(int|string|BCMathNumber|Number $number): Number
    {
        if (self::isChild($number)) $number = $number->getParent();
        if (is_int($number) || is_numeric($number)) $number = new BCMathNumber($number);
        if ((string)$number === '0') {
            return '-INF';
        }
        if ($number->compare('0') === static::COMPARE_RIGHT_GRATER) {
            return 'NAN';
        }

        $scale = static::DEFAULT_SCALE;
        $m = (string)log((float)(string)$number);
        $x = $number->div(static::exp($m), $scale)->sub(1, $scale);

        $res = new BCMathNumber(0);
        $pow = new BCMathNumber(1);

        $i = 1;
        do {
            $pow = $pow->mul($x, $scale);
            $sum = $pow->div($i, $scale);

            if ($i % 2 === 1) {
                $res = $res->add($sum, $scale);
            } else {
                $res = $res->sub($sum, $scale);
            }
            ++$i;
        } while ($sum->compare(0, $scale));

        return self::trimTrailingZeroes($res->add($m, $scale));
    }

    public static function compare(
        int|string|BCMathNumber $leftOperand,
        int|string|BCMathNumber $rightOperand,
        ?int $scale = null
    ): int {
        $leftOperand = static::convertToNumber($leftOperand);
        $rightOperand = static::convertToNumber($rightOperand);

        return $leftOperand->compare($rightOperand, self::getScaleForMethod($scale));
    }

    public static function setTrimTrailingZeroes(bool $flag): void
    {
        self::$trimTrailingZeroes = $flag;
    }

    /**
     * @param mixed $values
     */
    public static function max(...$values): null|BCMathNumber
    {
        $max = null;
        foreach (static::parseValues($values) as $number) {
            $number = static::convertToNumber((string)$number);
            if ($max === null) {
                $max = $number;
            } elseif ($max->compare($number) === static::COMPARE_RIGHT_GRATER) {
                $max = $number;
            }
        }

        return $max;
    }

    protected static function parseValues(array $values): array
    {
        if (is_array($values[0])) {
            $values = $values[0];
        }

        return $values;
    }

    /**
     * @param mixed $values
     */
    public static function min(...$values): null|BCMathNumber
    {
        $min = null;
        foreach (static::parseValues($values) as $number) {
            $number = static::convertToNumber((string)$number);
            if ($min === null) {
                $min = $number;
            } elseif ($min->compare($number) === static::COMPARE_LEFT_GRATER) {
                $min = $number;
            }
        }

        return $min;
    }

    /**
     * Return true if $number is positive, false otherwise.
     */
    protected static function isNegative(int|string|BCMathNumber|Number $number): bool
    {
        if (self::isChild($number)) $number = $number->getParent();
        return strncmp('-', (string)$number, 1) === 0;
    }

    /**
     * Return true if $number is negative, false otherwise.
     */
    protected static function isPositive(int|string|BCMathNumber|Number $number): bool
    {
        return ! self::isNegative($number);
    }

    public static function fact(int|string|BCMathNumber $number): BCMathNumber
    {
        $number = static::convertToNumber($number);

        if (static::isFloat($number)) {
            throw new InvalidArgumentException('BCMathNumber has to be an integer');
        }
        if (static::isNegative($number)) {
            throw new InvalidArgumentException('BCMathNumber has to be greater than or equal to 0');
        }

        $return = new BCMathNumber(1);
        for ($i = 2; $i <= (int)(string)$number; ++$i) {
            $return = $return->mul($i);
        }

        return $return;
    }

    /**
     * Return the absolute value of $number
     */
    public static function abs(int|string|BCMathNumber|Number $number): Number
    {
        if (self::isChild($number)) $number = $number->getParent();
        if (static::isNegative($number)) {
            $number = substr((string) $number, 1);
        }
        return new Number($number);
    }

    public function __toString(): string
    {
        return $this->number->value;
    }
}
