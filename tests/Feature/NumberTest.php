<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Number;
use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use RoundingMode;

#[TestDox("The Number class")]
class NumberTest extends BaseTestCase
{
    #[TestDox('extends the BcMath\\Number class through composition.')]
    public function test_getParent(): void
    {
        // Arrange
        $number = new Number($this->randomInteger());

        // Act & Assert
        $this->assertInstanceOf(BcMathNumber::class, $number->getParent());
    }

    #[TestDox("has a \"value\" property which is a string.")]
    public function test_value_property(): void
    {
        // Arrange
        $original_value = $this->string(
            $this->randomFloat(max: $this::MAX)
        );
        $number = new Number($original_value);

        // Act & Assert
        $this->assertSame($original_value, $number->value, "$original_value ≠ $number->value");
    }

    #[TestDox("has a \"scale\" property which is an int.")]
    public function test_scale_property(): void
    {
        // Arrange
        $original_number = $this->string(
            $this->randomFloatStrict(
                max: $this::MAX, 
                precision: $this->positiveRandomInteger(1, PHP_FLOAT_DIG)
            )
        );
        $scale = $this->countStringDecimalPlaces($original_number);
        $number = new Number($original_number);

        // Act & Assert
        $this->assertSame($scale, $number->scale, 
            "Does the number $original_number has $scale decimal places?");
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_to_string(): void
    {
        // Arrange
        $original_value = $this->string(
            $this->randomFloat(max: $this::MAX)
        );
        $number = new Number($original_value);

        // Act & Assert
        $this->assertSame($original_value, (string) $number);
    }

    #[TestDox("can be casted to float")]
    public function test_cast_to_float(): void
    {
        // Arrange
        $original_value = $this->string($this->randomFloat(max: $this::MAX));
        $number = new Number($original_value);

        // Act & Assert
        $this->assertEquals($original_value, $number->toFloat());
    }

    #[Depends("test_getParent")]
    #[DataProvider("addition")]
    #[TestDox("can be added to another one.")]
    public function test_addition(mixed $a, mixed $b, mixed $sum): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $SUM = $this->string($A->plus($B));

        // Assert
        $this->assertEquals($sum, $SUM, "$a + $b = $SUM");
    }

    #[Depends("test_getParent")]
    #[DataProvider("subtraction")]
    #[TestDox("can be subtracted from another one.")]
    public function test_subtraction(mixed $a, mixed $b, mixed $diff): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $DIFF = $this->string($A->sub($B));

        // Assert
        $this->assertEquals($diff, $DIFF, "$a - $b = $DIFF");
    }

    #[Depends("test_getParent")]
    #[DataProvider("multiplication")]
    #[TestDox("can be multiplied by another one.")]
    public function test_multiplication(mixed $a, mixed $b, mixed $prod): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $PROD = $this->string($A->mul($B));

        // Assert
        $this->assertEquals($prod, $PROD, "$a * $b = $PROD");
    }

    #[Depends("test_getParent")]
    #[DataProvider("dividends")]
    #[TestDox("can be divided by another")]
    public function test_division(mixed $a, mixed $b, mixed $quot): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $QUOT = $this->string($A->div($B)->getParent()->value);

        // Assert
        $this->assertEquals($quot, $QUOT, "$a / $b = $QUOT");
    }

    #[Depends("test_getParent")]
    #[Depends("test_division")]
    #[Depends("test_floor")]
    #[Depends("test_multiplication")]
    #[Depends("test_subtraction")]
    #[DataProvider("remainders")]
    #[TestDox("can be divided by another and obtain the remainder of the division.")]
    public function test_modulo(mixed $a, mixed $b, mixed $rem): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $REM = $this->string($A->mod($B)->getParent()->value);

        // Assert
        $this->assertEquals($rem, $REM, "$a mod $b = $REM");
    }

    #[Depends("test_getParent")]
    #[Depends("test_division")]
    #[Depends("test_floor")]
    #[Depends("test_multiplication")]
    #[Depends("test_subtraction")]
    #[DataProvider("quotientAndRemainders")]
    #[TestDox("can be divided by another and obtain the integer quotient and remainder of the division.")]
    public function test_division_modulo(mixed $a, mixed $b, mixed $quot, mixed $rem): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        [$QUOT, $REM] = $A->divmod($B);
        $QUOT = $this->string($QUOT->getParent()->value);
        $REM = $this->string($REM->getParent()->value);

        // Assert
        $this->assertEquals($quot, $QUOT, "floor($a / $b) = $QUOT");
        $this->assertEquals($rem, $REM, "$a mod $b = $REM");
    }
    
    #[Depends("test_getParent")]
    #[DataProvider("power")]
    #[TestDox("can be elevated to an exponent.")]
    public function test_power(mixed $b, mixed $e, mixed $pow): void
    {
        // Arrange
        $B = $this->instantiateNumber($b);
        $E = $this->instantiateNumber($e);

        // Act
        $POW = $this->string($B->pow($E)->getParent()->value);

        // Assert
        $this->assertEquals($pow, $POW, "$b ^ $e = $POW");
    }

    #[Depends("test_getParent")]
    #[Depends("test_division")]
    #[Depends("test_floor")]
    #[Depends("test_multiplication")]
    #[Depends("test_subtraction")]
    #[DataProvider("powerModulo")]
    #[TestDox("can be elevated to an exponent and divided by a modulus to obtain the remainder.")]
    public function test_power_modulo(mixed $b, mixed $e, mixed $m, mixed $pow_mod): void
    {
        // Arrange
        $B = $this->instantiateNumber($b);
        $E = $this->instantiateNumber($e);
        $M = $this->instantiateNumber($m);
        
        // Act
        $POWMOD = $this->string($B->powmod($E, $M)->getParent()->value);

        // Assert
        $this->assertEquals($pow_mod, $POWMOD, "($b ^ $e) mod $m = $POWMOD");
    }

    #[Depends("test_getParent")]
    #[DataProvider("squareRoot")]
    #[TestDox("can calculate the square root of itself.")]
    public function test_square_root(mixed $n, mixed $sqrt): void
    {
        // Arrange
        $N = $this->instantiateNumber($n);

        // Act
        $SQRT = $this->string($N->sqrt()->getParent()->value);

        // Assert
        $this->assertEquals($sqrt, $SQRT, "sqrt($n) = $SQRT");
    }

    #[Depends("test_getParent")]
    #[DataProvider("rounding")]
    #[TestDox("can round its value to a specified precision.")]
    public function test_round(mixed $num, int $prec, mixed $rnd): void
    {
        // Arrange
        $NUM = $this->instantiateNumber($num);

        // Act
        $RND = $this->string($NUM->round($prec)->getParent()->value);

        // Assert
        $this->assertEquals($rnd, $RND, "round($NUM, $prec) = $RND");
    }

    #[Depends("test_getParent")]
    #[DataProvider("floor")]
    #[TestDox("can return its floor value.")]
    public function test_floor(mixed $num, mixed $flr): void
    {
        // Arrange
        $NUM = $this->instantiateNumber($num);

        // Act
        $FLR = $this->string($NUM->floor()->getParent()->value);

        // Assert
        $this->assertEquals($flr, $FLR, "floor($num) = $FLR");
    }

    #[Depends("test_getParent")]
    #[DataProvider("ceil")]
    #[TestDox("can return its ceil value.")]
    public function test_ceil(mixed $num, mixed $ceil): void
    {
        // Arrange
        $NUM = $this->instantiateNumber($num);

        // Act
        $CEIL = $this->string($NUM->ceil()->getParent()->value);

        // Assert
        $this->assertEquals($ceil, $CEIL, "ceil($num) = $CEIL");
    }

    #[Depends("test_getParent")]
    #[DataProvider("max")]
    #[TestDox("can calculate the max value in a list of numbers.")]
    public function test_max(array $nums, mixed $max): void
    {
        // Act
        $MAX = $this->string(Number::max(...$nums)->getParent()->value);

        // Assert
        $this->assertEquals($max, $MAX, $this->getMaxErrorMessage($nums, $MAX));
    }

    #[Depends("test_getParent")]
    #[DataProvider("min")]
    #[TestDox("can calculate the min value in a list of numbers.")]
    public function test_min(array $nums, mixed $min): void
    {
        // Arrange
        $NUMS = $this->instantiateNumbers($nums);

        // Act
        $MIN = $this->string(Number::min(...$NUMS)->getParent()->value);

        // Assert
        $this->assertEquals($min, $MIN, $this->getMinErrorMessage($nums, $MIN));
    }

    #[Depends("test_getParent")]
    #[Depends("test_isFloat")]
    #[DataProvider("factorials")]
    #[TestDox("can calculate the factorial of itself")]
    public function test_factorial(mixed $n, mixed $fact): void
    {
        // Arrange
        $N = $this->instantiateNumber($n);

        // Act
        $FACT = $N->fact();

        // Assert
        $this->assertEquals($fact, $FACT->getParent()->value, "$N! = $FACT");
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if a number is a decimal.")]
    public function test_isFloat(): void
    {
        // Arrange
        $NUM = new Number($this->string($this->randomFloatStrict(max: $this::MAX)));

        // Act & Assert
        $this->assertTrue($res = $NUM->isFloat(), "Is $NUM a float? $res");
    }

    #[Depends("test_getParent")]
    #[Depends("test_isFloat")]
    #[TestDox("can check if a number is an integer.")]
    public function test_isInt(): void
    {
        // Arrange
        $number = $this->instantiateNumber($this->randomInteger());

        // Act & Assert
        $this->assertTrue($res = $number->isInt(), "Is $number a int? $res");
    }

    #[Depends("test_getParent")]
    #[Depends("test_isNegative")]
    #[TestDox("can calculate the absolute number of itself")]
    public function test_abs(): void
    {
        // Arrange
        /**
         * Warning! Floating point imprecision ahead!
         * Solution: round the floating point number to
         * a lower precision.
         */
        $number = $this->instantiateNumber(
            $original_number = round(
                $this->randomFloat(max: $this::MAX)),
                3,
                RoundingMode::HalfTowardsZero
        );

        // Act
        $absolute = $number->abs();

        // Assert
        $this->assertEquals(abs($original_number), $absolute->value, "abs($original_number) = $absolute");
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is a positive number.")]
    public function test_isPositive(): void
    {
        // Arrange
        $number = $this->instantiateNumber(
            $this->string(
                $this->positiveRandomFloat(max: $this::MAX)
            )
        );

        // Act & Assert
        $error_message = "$number is not positive.";
        $this->assertTrue($number->isPositive(), $error_message);
        $this->assertFalse($number->isNegative(), $error_message);
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is a negative number.")]
    public function test_isNegative(): void
    {
        // Arrange
        $number = $this->instantiateNumber(
            $this->string(
                $this->negativeRandomFloat(max: $this::MAX)
            )
        );

        // Act & Assert
        $error_message = "$number is not negative.";
        $this->assertTrue($number->isNegative(), $error_message);
        $this->assertFalse($number->isPositive(), $error_message);
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is equal to another number.")]
    public function test_isEqual(): void
    {
        // Arrange
        $number_A = $number_B = $this->instantiateNumber(
            $this->string($this->randomFloat(max: $this::MAX))
        ); 

        // Act & Assert
        $this->assertTrue($number_A->eq($number_B), "$number_A ≠ $number_B");
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is different from another number.")]
    public function test_isDifferent(): void
    {
        // Arrange
        $number_A = $this->instantiateNumber(
            $this->string($this->randomFloat(max: $this::MAX))
        );
        $number_B = $number_A->sub($this->string($this->randomFloat(max: $this::MAX)));

        // Act & Assert
        $this->assertTrue($number_A->not($number_B), "$number_A ≠ $number_B");      
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is less than another number.")]
    public function test_isLessThan(): void
    {
        // Arrange
        $number_A = $this->instantiateNumber(
            $this->string($this->randomFloat(max: $this::MAX))
        );
        $number_B = $number_A->sub($this->string($this->positiveRandomFloat(max: $this::MAX)));

        // Act & Assert
        $this->assertTrue($number_B->lt($number_A), "$number_B ≮ $number_A");
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is less than or equal to another number.")]
    public function test_isLessThanOrEqual(): void
    {
        // Arrange
        $number_A = $this->instantiateNumber(
            $this->string($this->randomFloat(max: $this::MAX))
        );
        $number_B = $number_A->sub($this->string($this->positiveRandomFloat(max: $this::MAX)));

        // Act & Assert
        $this->assertTrue($number_B->lte($number_A), "$number_B ≰ $number_A");
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is greater than another number.")]
    public function test_isGreaterThan(): void
    {
        // Arrange
        $number_A = $this->instantiateNumber(
            $this->string($this->randomFloat(max: $this::MAX))
        );
        $number_B = $number_A->sub($this->string($this->positiveRandomFloat(max: $this::MAX)));

        // Act & Assert
        $this->assertTrue($number_A->gt($number_B), "$number_A ≯ $number_B");
    }

    #[Depends("test_getParent")]
    #[TestDox("can check if it is greater than or equal to another number.")]
    public function test_isGreaterThanOrEqual(): void
    {
        // Arrange
        $number_A = $this->instantiateNumber(
            $this->string($this->randomFloat(max: $this::MAX))
        );
        $number_B = $number_A->sub($this->string($this->positiveRandomFloat(max: $this::MAX)));

        // Act & Assert
        $this->assertTrue($number_A->gte($number_B), "$number_A ≱ $number_B");
    }

    // #[DataProvider("logarithm")]
    // #[TestDox("can calculate the logarithm of itself with a specified base.")]
    // public function test_logarithm(mixed $arg, mixed $base, mixed $log): void
    // {
    //     // Arrange
    //     $ARG = $this->instantiateNumber($arg);

    //     // Act
    //     $LOG = $this->string($ARG->log($base, 13)->getParent()->value);

    //     // Assert
    //     $this->assertEquals($log, $LOG, "log($arg, $base) = $LOG");
    // }
}