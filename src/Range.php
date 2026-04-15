<?php
namespace MarcoConsiglio\BCMathExtended;

use BcMath\Number as BcMathNumber;

/**
 * The numeric range.
 */
class Range
{
    /**
     * Construct a numeric `Range`.
     * 
     * @param int|float|string|BcMathNumber|Number $start The lower extreme of this `Range`.
     * @param int|float|string|BcMathNumber|Number $end The higher extreme of this `Range`.
     */
    public function __construct(
        public protected(set) int|float|string|BcMathNumber|Number $start,
        public protected(set) int|float|string|BcMathNumber|Number $end
    ) {}
}