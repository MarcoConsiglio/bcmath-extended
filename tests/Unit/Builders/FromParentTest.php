<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Unit\Builders;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Builders\FromParent;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FromParent::class)]
#[UsesClass(Number::class)]
class FromParentTest extends BaseTestCase
{
    public function test_builder(): void
    {
        // Arrange
        $number = new BcMathNumber($this->randomInteger());
        $builder = new FromParent($number);

        // Act & Assert
        $this->assertSame(new Number($number)->value, $builder->getResult()->value);
    }
}