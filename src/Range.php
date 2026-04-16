<?php
namespace MarcoConsiglio\BCMathExtended;

use BcMath\Number as BcMathNumber;

/**
 * The numeric range.
 */
class Range
{
    /**
     * The lower extreme of this `Range`.
     */
    public protected(set) Number $start;

    /**
     * The higher extreme of this `Range`.
     */
    public protected(set) Number $end;

    /**
     * Construct a numeric `Range`.
     * 
     * @param int|float|string|BcMathNumber|Number $start 
     * @param int|float|string|BcMathNumber|Number $end 
     */
    public function __construct(
        int|float|string|BcMathNumber|Number $start,
        int|float|string|BcMathNumber|Number $end
    ) {
        if ($start instanceof Number) $this->start = $start;
        else $this->start = new Number($start);
        if ($end instanceof Number) $this->end = $end;
        else $this->end = new Number($end);
    }
}