<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Feature;

use MarcoConsiglio\BCMathExtended\Number;
use MarcoConsiglio\BCMathExtended\Random;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;

class RandomTest extends BaseTestCase
{
    public function test_random_number(): void
    {
        // Act & Assert
        $this->assertInstanceOf(Number::class, Random::number(0, 100));
    }

    // public function test_generate_random_list(): void
    // {
    //     // Use this test to play with random numbers.
    //     // You will find your random generated numbers in ./random.txt
    //     $this->expectNotToPerformAssertions();
    //     $file = './random.txt';
    //     $min = 1;
    //     $max = 6;
    //     for ($i = 0;  $i < 10; $i++) {
    //         $number = Random::number($min, $max);
    //         $number = $number->round(0);
    //         if ($number->gt($max)) $number->sub(1);
    //         $list[] = $number . PHP_EOL;
    //     }
    //     file_put_contents($file, $list);
    // }
}