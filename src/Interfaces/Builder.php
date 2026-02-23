<?php
namespace MarcoConsiglio\BCMathExtended\Interfaces;

use BcMath\Number as BcMathNumber;

/**
 * The concept of a Number builder.
 */
interface Builder
{
    /**
     * Get the builder output.
     */
    public function getResult(): BcMathNumber;
}