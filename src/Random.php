<?php
declare(strict_types=1);

namespace MarcoConsiglio\BCMathExtended;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;

/**
 * Generate a random number.
 */
class Random
{
    /**
     * Generate a random number.
     */
    public static function number(int|string|BCMathNumber|Number $min, int|string|BCMathNumber|Number $max): Number
    {
        $min = new Number($min);
        $max = new Number($max);
        $max_rand = new Number(mt_getrandmax());
        if ($min->lt(0)) $min = new Number(0);
        if ($max->gt($max_rand)) $max = $max_rand;
        $difference = $max->sub($min)->add(1);
        $random_integer = new Number(mt_rand());
        $randPercent = $random_integer->divide($max_rand);
        return $difference->mul($randPercent)->add(1);
    }
}