<?php
declare(strict_types=1);
namespace MarcoConsiglio\BCMathExtended\Tests\Unit;

use MarcoConsiglio\BCMathExtended\Builders\FromBcMathNumber;
use MarcoConsiglio\BCMathExtended\Builders\FromInt;
use MarcoConsiglio\BCMathExtended\Builders\FromString;
use MarcoConsiglio\BCMathExtended\Exceptions\NotANumberError;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use MarcoConsiglio\BCMathExtended\Tests\Feature\NumberTest as FeatureNumberTest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DependsExternal;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
// use MarcoConsiglio\BCMathExtended\Exceptions\IndeterminateFormError;
// use MarcoConsiglio\BCMathExtended\Exceptions\InfiniteError;
// use MarcoConsiglio\BCMathExtended\Exceptions\NotANumberError;

#[TestDox("The BcMathExtended\\Number class")]
#[CoversClass(Number::class)]   
#[UsesClass(NotANumberError::class)]
#[UsesClass(FromInt::class)]
#[UsesClass(FromString::class)]
#[UsesClass(FromBcMathNumber::class)]
// #[UsesClass(InfiniteError::class)]
// #[UsesClass(IndeterminateFormError::class)]
class NumberTest extends BaseTestCase
{
    #[TestDox("can statically check if an instance is a child of BCMath\\Number class.")]
    public function test_isChild(): void
    {
        // Arrange
        $number = new Number($this->randomInteger());

        // Act & Assert
        $this->assertTrue(Number::isChild($number));
    }

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

    #[DependsExternal(FeatureNumberTest::class, "test_factorial")]
    #[TestDox("throws NotANumberError when trying to calculate factorial with a decimal number.")]
    public function test_factorial_with_float_input(): void
    {
        // Arrange
        $n = $this->positiveRandomFloatStrict(max: self::MAX);
        $N = $this->instantiateNumber($this->string($n));

        // Assert
        $this->expectException(NotANumberError::class);
        $this->expectExceptionMessage("Cannot calculate the expression $N!.");

        // Act
        $N->factorial();
    }

    #[DependsExternal(FeatureNumberTest::class, "test_factorial")]
    #[TestDox("throws NotANumberError when trying to calculate factorial with a negative number.")]
    public function test_factorial_with_negative_number(): void
    {
        // Arrange
        $n = $this->negativeRandomInteger();
        $N = $this->instantiateNumber($n);

        // Assert
        $this->expectException(NotANumberError::class);
        $this->expectExceptionMessage("Cannot calculate the expression $N!.");

        // Act
        $N->factorial();
    }

    #[DataProvider("positiveAbs")]
    #[DependsExternal(FeatureNumberTest::class, "test_abs")]
    #[TestDox("can calculate the absolute number of itself, so a positive number remains the same.")]
    public function test_positive_absolute(mixed $n, mixed $abs): void
    {
        // Arrange
        $N = $this->instantiateNumber($n);

        // Act
        $ABS = $this->string($N->abs()->getParent()->value);

        // Assert
        $this->assertEquals($abs, $ABS, "abs($N) = $ABS");
    }

    #[DataProvider("negativeAbs")]
    #[DependsExternal(FeatureNumberTest::class, "test_abs")]
    #[TestDox("can calculate the absolute number of itself, so a negative number become a positive one.")]
    public function test_negative_absolute(mixed $n, mixed $abs): void
    {
        // Arrange
        $N = $this->instantiateNumber($n);

        // Act
        $ABS = $this->string($N->abs()->getParent()->value);

        // Assert
        $this->assertEquals($abs, $ABS, "abs($N) = $ABS");
    }

    #[DependsExternal(FeatureNumberTest::class, "test_getParent")]
    #[DependsExternal(FeatureNumberTest::class, "test_isFloat")]
    #[TestDox("can check if a number is not a decimal.")]
    public function test_is_not_float(): void
    {
        // Arrange
        $number = $this->instantiateNumber($this->randomInteger());

        // Act & Assert
        $this->assertFalse($res = $number->isFloat(), "Is $number a float? $res");
    }

    #[DependsExternal(FeatureNumberTest::class, "test_getParent")]
    #[DependsExternal(FeatureNumberTest::class, "test_isFloat")]
    #[TestDox("can check if a number is not an integer.")]
    public function test_is_not_int(): void
    {
        // Arrange
        $float_number = $this->randomFloatStrict(max: $this::MAX);
        $number = $this->instantiateNumber($this->string($float_number));

        // Act & Assert
        $this->assertFalse($res = $number->isInt(), "Is $number a int? $res");       
    }
}
