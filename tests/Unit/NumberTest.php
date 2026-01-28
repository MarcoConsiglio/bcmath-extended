<?php
declare(strict_types=1);
namespace MarcoConsiglio\BCMathExtended\Tests\Unit;

use MarcoConsiglio\BCMathExtended\Number;
use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Number class")]
#[CoversClass(Number::class)]
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
    #[TestDox("can be elevated to another one.")]
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

    protected function instantiateNumber(mixed $number): Number
    {
        return $number instanceof Number ? $number : new Number($number);
    }
}
