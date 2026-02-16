<?php
declare(strict_types=1);
namespace MarcoConsiglio\BCMathExtended\Tests\Unit;

use MarcoConsiglio\BCMathExtended\Number;
use BcMath\Number as BcMathNumber;
// use MarcoConsiglio\BCMathExtended\Exceptions\IndeterminateFormError;
// use MarcoConsiglio\BCMathExtended\Exceptions\InfiniteError;
// use MarcoConsiglio\BCMathExtended\Exceptions\NotANumberError;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The BcMathExtended\\Number class")]
#[CoversClass(Number::class)]   
// #[UsesClass(InfiniteError::class)]
// #[UsesClass(NotANumberError::class)]
// #[UsesClass(IndeterminateFormError::class)]
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

    #[TestDox("can statically check if an instance is a child of BcMath\\Number class.")]
    public function test_isChild(): void
    {
        // Arrange
        $number = new Number($this->randomInteger());

        // Act & Assert
        $this->assertTrue(Number::isChild($number));
    }

    #[DataProvider("addition")]
    #[TestDox("can be added to another one.")]
    public function test_addition(mixed $a, mixed $b, mixed $sum): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $SUM = self::string($A->plus($B)->getParent()->value);

        // Assert
        $this->assertEquals($sum, $SUM, "$a + $b = $SUM");
    }

    #[DataProvider("subtraction")]
    #[TestDox("can be subtracted from another one.")]
    public function test_subtraction(mixed $a, mixed $b, mixed $diff): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $DIFF = self::string($A->sub($B)->getParent()->value);

        // Assert
        $this->assertEquals($diff, $DIFF, "$a - $b = $DIFF");
    }

    #[DataProvider("multiplication")]
    #[TestDox("can be multiplied by another one.")]
    public function test_multiplication(mixed $a, mixed $b, mixed $prod): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $PROD = self::string($A->mul($B)->getParent()->value);

        // Assert
        $this->assertEquals($prod, $PROD, "$a * $b = $PROD");
    }

    #[DataProvider("dividends")]
    #[TestDox("can be divided by another")]
    public function test_division(mixed $a, mixed $b, mixed $quot): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $QUOT = self::string($A->div($B)->getParent()->value);

        // Assert
        $this->assertEquals($quot, $QUOT, "$a / $b = $QUOT");
    }

    #[DataProvider("remainders")]
    #[TestDox("can be divided by another and obtain the remainder of the division.")]
    public function test_modulo(mixed $a, mixed $b, mixed $rem): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $REM = self::string($A->mod($B)->getParent()->value);

        // Assert
        $this->assertEquals($rem, $REM, "$a mod $b = $REM");
    }

    #[DataProvider("quotientAndRemainders")]
    #[TestDox("can be divided by another and obtain the integer quotient and remainder of the division.")]
    public function test_division_modulo(mixed $a, mixed $b, mixed $quot, mixed $rem): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        [$QUOT, $REM] = $A->divmod($B);
        $QUOT = self::string($QUOT->getParent()->value);
        $REM = self::string($REM->getParent()->value);

        // Assert
        $this->assertEquals($quot, $QUOT, "floor($a / $b) = $QUOT");
        $this->assertEquals($rem, $REM, "$a mod $b = $REM");
    }
    
    #[DataProvider("power")]
    #[TestDox("can be elevated to an exponent.")]
    public function test_power(mixed $b, mixed $e, mixed $pow): void
    {
        // Arrange
        $B = $this->instantiateNumber($b);
        $E = $this->instantiateNumber($e);

        // Act
        $POW = self::string($B->pow($E)->getParent()->value);

        // Assert
        $this->assertEquals($pow, $POW, "$b ^ $e = $POW");
    }

    #[DataProvider("powerModulo")]
    #[TestDox("can be elevated to an exponent and divided by a modulus to obtain the remainder.")]
    public function test_power_modulo(mixed $b, mixed $e, mixed $m, mixed $pow_mod): void
    {
        // Arrange
        $B = $this->instantiateNumber($b);
        $E = $this->instantiateNumber($e);
        $M = $this->instantiateNumber($m);
        
        // Act
        $POWMOD = self::string($B->powmod($E, $M)->getParent()->value);

        // Assert
        $this->assertEquals($pow_mod, $POWMOD, "($b ^ $e) mod $m = $POWMOD");
    }

    #[DataProvider("squareRoot")]
    #[TestDox("can calculate the square root of itself.")]
    public function test_square_root(mixed $n, mixed $sqrt): void
    {
        // Arrange
        $N = $this->instantiateNumber($n);

        // Act
        $SQRT = self::string($N->sqrt()->getParent()->value);

        // Assert
        $this->assertEquals($sqrt, $SQRT, "sqrt($n) = $SQRT");
    }

    // #[DataProvider("logarithm")]
    // #[TestDox("can calculate the logarithm of itself with a specified base.")]
    // public function test_logarithm(mixed $arg, mixed $base, mixed $log): void
    // {
    //     // Arrange
    //     $ARG = $this->instantiateNumber($arg);

    //     // Act
    //     $LOG = self::string($ARG->log($base, 13)->getParent()->value);

    //     // Assert
    //     $this->assertEquals($log, $LOG, "log($arg, $base) = $LOG");
    // }

    // public function test_logarithm_negative_argument_error(): void
    // {
    //     // Act
    //     $arg = $this->negativeNonZeroRandomInteger();
    //     $base = $this->positiveRandomInteger();

    //     // Assert
    //     $this->expectException(NotANumberError::class);

    //     // Act
    //     (new Number($arg))->log($base);
    // }

    // public function test_logarithm_negative_base_error(): void
    // {
    //     // Act
    //     $arg = $this->positiveNonZeroRandomInteger(min: 2);
    //     $base = $this->negativeNonZeroRandomInteger();

    //     // Assert
    //     $this->expectException(IndeterminateFormError::class);

    //     // Act
    //     (new Number($arg))->log($base);   
    // }

    // public function test_logarithm_argument_zero(): void
    // {
    //     // Act
    //     $arg = 0;
    //     $base = $this->positiveNonZeroRandomInteger(min: 2);

    //     // Assert
    //     $this->expectException(InfiniteError::class);

    //     // Act
    //     (new Number($arg))->log($base);   
    // }

    // public function test_logarithm_argument_and_base_zero(): void
    // {
    //     // Act
    //     $arg = 0;
    //     $base = 0;

    //     // Assert
    //     $this->expectException(IndeterminateFormError::class);

    //     // Act
    //     (new Number($arg))->log($base);          
    // }

    // public function test_logarithm_argument_one(): void
    // {
    //     // Act
    //     $arg = 1;
    //     $base = $this->positiveRandomInteger(min: 2);

    //     // Assert
    //     $this->expectException(NotANumberError::class);

    //     // Act
    //     (new Number($arg))->log($base);        
    // }

    // public function test_logarithm_argument_and_base_one(): void
    // {
    //     // Act
    //     $arg = 1;
    //     $base = 1;

    //     // Assert
    //     $this->expectException(IndeterminateFormError::class);

    //     // Act
    //     (new Number($arg))->log($base);       
    // }

    #[DataProvider("rounding")]
    #[TestDox("can round its value to a specified precision.")]
    public function test_round(mixed $num, int $prec, mixed $rnd): void
    {
        // Arrange
        $NUM = $this->instantiateNumber($num);

        // Act
        $RND = self::string($NUM->round($prec)->getParent()->value);

        // Assert
        $this->assertEquals($rnd, $RND, "round($NUM, $prec) = $RND");
    }

    #[DataProvider("floor")]
    #[TestDox("can return its floor value.")]
    public function test_floor(mixed $num, mixed $flr): void
    {
        // Arrange
        $NUM = $this->instantiateNumber($num);

        // Act
        $FLR = self::string($NUM->floor()->getParent()->value);

        // Assert
        $this->assertEquals($flr, $FLR, "floor($num) = $FLR");
    }

    #[DataProvider("ceil")]
    #[TestDox("can return its ceil value.")]
    public function test_ceil(mixed $num, mixed $ceil): void
    {
        // Arrange
        $NUM = $this->instantiateNumber($num);

        // Act
        $CEIL = self::string($NUM->ceil()->getParent()->value);

        // Assert
        $this->assertEquals($ceil, $CEIL, "ceil($num) = $CEIL");
    }

    #[DataProvider("max")]
    #[TestDox("can calculate the max value in a list of numbers.")]
    public function test_max(array $nums, mixed $max): void
    {
        // Arrange
        foreach ($nums as $index => $num) {
            $NUMS[$index] = $this->instantiateNumber($num);
        }

        // Act
        $MAX = self::string(Number::max(...$NUMS)->getParent()->value);

        // Assert
        $this->assertEquals($max, $MAX, $this->getMaxErrorMessage($nums, $MAX));
    }

    #[DataProvider("min")]
    #[TestDox("can calculate the min value in a list of numbers.")]
    public function test_min(array $nums, mixed $min): void
    {
        // Arrange
        // $NUMS = $this->instantiateNumbers($nums);

        // Act
        $MIN = self::string(Number::min(...$nums)->getParent()->value);

        // Assert
        $this->assertEquals($min, $MIN, $this->getMinErrorMessage($nums, $MIN));
    }

    #[DataProvider("floats")]
    #[TestDox("can check if a number is a decimal.")]
    public function test_is_float(mixed $num, bool $res): void
    {
        // Arrange
        $NUM = $this->instantiateNumber($num);

        // Act
        $RES = $NUM->isFloat();

        // Assert
        $this->assertEquals($res, $RES, "Is $NUM a float? $RES");
    }

    #[TestDox("can check if a number is not a decimal.")]
    public function test_is_not_float(): void
    {
        // Arrange
        $number = $this->instantiateNumber($this->randomInteger());

        // Act & Assert
        $this->assertFalse($number->isFloat(), "Is $number a float?");
    }

    /**
     * Instantiate a BcMathExtended\Number class from an int, string or
     * BcMath\Number instance, is is not already a BcMathExtended\Number
     * instance.
     * 
     * @param int|string|BcMathNumber|Number $number
     */
    protected function instantiateNumber(mixed $number): Number
    {
        return $number instanceof Number ? $number : new Number($number);
    }

    /**
     * Instantiate an array of BcMathExtended\Number instances.
     * 
     * @param int[]|string[]|BcMathNumber[]|Number[] $numbers
     * @return Number[]
     */
    protected function instantiateNumbers(array $numbers): array
    {
        foreach ($numbers as $index => $number) {
            $numbers[$index] = $this->instantiateNumber($number);
        }
        return $numbers;
    }

    /**
     * Return an error message for the operation max($vars) = $max.
     */
    protected function getMaxErrorMessage(mixed $vars, mixed $max): string
    {
        return $this->getMinOrMaxErrorMessage("max", $vars, $max);
    }

    /**
     * Return an error message for the operation min($vars) = $min.
     */   
    protected function getMinErrorMessage(mixed $vars, mixed $min): string
    {
        return $this->getMinOrMaxErrorMessage("min", $vars, $min);
    }

    /**
     * Return an error message for the operation max or min.
     */
    private function getMinOrMaxErrorMessage(string $min_or_max, mixed $vars, mixed $result): string
    {
        if ($min_or_max != "min" && $min_or_max != "max") $min_or_max = "max";
        $message = "$min_or_max(";
        $count = count($vars);
        for ($i = 0; $i <= $count - 1; $i++) {
            if ($i == $count - 1) {
                $message .= $vars[$i].")";
            } else $message .= $vars[$i].", ";
        }
        $message .= " = $result";
        return $message;       
    }
}
