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

    #[DataProvider("addends")]
    #[TestDox("can be added to another one.")]
    public function test_addition(mixed $a, mixed $b, mixed $sum): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $SUM = self::string($A->plus($B)->getParent()->value);

        // Assert
        $this->assertEquals($sum, $SUM, "$a + $b = $sum");
    }

    #[DataProvider("minuends")]
    #[TestDox("can be subtracted from another one.")]
    public function test_subtraction(mixed $a, mixed $b, mixed $diff): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $DIFF = self::string($A->sub($B)->getParent()->value);

        // Assert
        $this->assertEquals($diff, $DIFF, "$a - $b = $diff");
    }

    #[DataProvider("factors")]
    #[TestDox("can be multiplied by another one.")]
    public function test_multiplication(mixed $a, mixed $b, mixed $prod): void
    {
        // Arrange
        $A = $this->instantiateNumber($a);
        $B = $this->instantiateNumber($b);

        // Act
        $PROD = self::string($A->mul($B)->getParent()->value);

        // Assert
        $this->assertEquals($prod, $PROD, "$a * $b = $prod");
    }

    protected function instantiateNumber(mixed $number): Number
    {
        return $number instanceof Number ? $number : new Number($number);
    }
}
