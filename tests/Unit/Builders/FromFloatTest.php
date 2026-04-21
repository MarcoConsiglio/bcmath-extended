<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Unit\Builders;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Builders\FromFloat;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FromFloat::class)]
#[UsesClass(Number::class)]
class FromFloatTest extends BaseTestCase
{
    public function test_builder(): void
    {
        // Arrange
        $float = $this->randomFloat($this::MIN, $this::MAX);
        $builder = new FromFloat($float);
        $expected = new Number($float);

        // Act
        $actual = $builder->getResult();

        // Assert
        $this->assertSame($expected->getParent()->value, $actual->value);
    }
}