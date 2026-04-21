<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Unit\Builders;

use BcMath\Number;
use MarcoConsiglio\BCMathExtended\Builders\FromInt;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FromInt::class)]
class FromIntTest extends BaseTestCase
{
    public function test_builder(): void
    {
        // Arrange
        $int = $this->randomInteger();
        $builder = new FromInt($int);
        $expected = new Number($int);
        
        // Act & Assert
        $this->assertSame($expected->value, $builder->getResult()->value);
    }
}