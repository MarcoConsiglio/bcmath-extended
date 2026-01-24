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
    public function test_addition(mixed $a, mixed $b, mixed $sum): void
    {
        // Act
        $A = $a instanceof Number ? $a : new Number($a);
        $B = $b instanceof Number ? $b : new Number($b);
        $SUM = $A->add($B)->getParent()->value;

        // Assert
        $this->assertEquals($sum, $SUM, "$a + $b = $sum");
    }
}
