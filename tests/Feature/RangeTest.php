<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Builders\FromFloat;
use MarcoConsiglio\BCMathExtended\Builders\FromInt;
use MarcoConsiglio\BCMathExtended\Builders\FromParent;
use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\BCMathExtended\Range;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Range::class)]
#[UsesClass(FromFloat::class)]
#[UsesClass(Number::class)]
#[UsesClass(FromInt::class)]
#[UsesClass(FromParent::class)]
class RangeTest extends BaseTestCase
{
    public function test_range(): void
    {
        /**
         *  $start Number type
         *  $end Number type
         */
        // Arrange
        $start = $this->randomNumber(max: 0);
        $end = $this->randomNumber(min: 1);

        // Act
        $range = new Range($start, $end);

        // Assert
        $this->assertSame($start, $range->start);
        $this->assertSame($end, $range->end);

        /**
         * $start other type
         * $end Number type
         */
        // Arrange
        $start = $this->randomInteger(max: 0);
        $end = $this->randomNumber(min: 1);

        // Act
        $range = new Range($start, $end);

        // Assert
        $this->assertSame(new Number($start)->value, $range->start->value);
        $this->assertSame($end, $range->end);

        /**
         * $start Number type
         * $end other type
         */
        // Arrange
        $start = $this->randomNumber(max: 0);
        $end = $this->randomInteger(min: 1);

        // Act
        $range = new Range($start, $end);

        // Assert
        $this->assertSame($start, $range->start);
        $this->assertSame(new Number($end)->value, $range->end->value);

        /**
         * $start other type
         * $end other type
         */
        // Arrange
        $start = $this->randomInteger(max: 0);
        $end = $this->randomInteger(min: 1);

        // Act
        $range = new Range($start, $end);

        // Assert
        $this->assertSame(new Number($start)->value, $range->start->value);
        $this->assertSame(new Number($end)->value, $range->end->value);
    }

    public function test_range_extremes_excluded(): void
    {
        // Arrange
        $start = -10;
        $end = -$start;
        $range = new Range($start, $end); 
        $expected_start = NextFloat::before($start);
        $expected_end = NextFloat::after($end);

        // Act
        $range = new Range($start, $end);

        // Assert
        $this->assertEquals($expected_start, $range->start_excluded->toFloat());
        $this->assertEquals($expected_end, $range->end_excluded->toFloat());
    }
}