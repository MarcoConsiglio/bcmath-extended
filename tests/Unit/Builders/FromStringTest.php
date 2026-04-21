<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Unit\Builders;

use MarcoConsiglio\BCMathExtended\Builders\FromString;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(FromString::class)]
#[UsesClass(Number::class)]
class FromStringTest extends BaseTestCase
{
    public function test_builder(): void
    {
        // Arrange
        $string = (string) $this->randomInteger();
        $builder = new FromString($string);
        $expected = new Number($string);

        // Act & Assert
        $this->assertSame($expected->value, $builder->getResult()->value);
    }
}