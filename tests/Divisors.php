<?php
namespace MarcoConsiglio\BCMathExtended\Tests;

class Divisors
{
    public static function of(int $number): array
    {
        $divisors = [];
        for ($i = 1; $i <= abs($number); $i++) {
            if (abs($number) % $i == 0) $divisors[] = $i;
        }
        return $divisors;
    }
}