<?php
declare(strict_types=1);

namespace MarcoConsiglio\BCMathExtended;

use BcMath\Number as BCMathNumber;
use MarcoConsiglio\BCMathExtended\Number;

class Random
{
    public static function number(int|string|BCMathNumber|Number $min, int|string|BCMathNumber|Number $max): Number
    {
        if (Number::isChild($min)) $min = $min->getParent();
        if (Number::isChild($max)) $max = $max->getParent();
        $difference = $max->sub($min)->add(1);
        $random_integer = new Number(mt_rand());
        $max_random_integer = new Number(mt_getrandmax());
        $randPercent = $random_integer->divide($max_random_integer, PHP_FLOAT_DIG);
        return $difference->mul($randPercent, PHP_FLOAT_DIG)->add(1, 0);
    }
}