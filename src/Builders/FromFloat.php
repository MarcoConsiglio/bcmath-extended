<?php
namespace MarcoConsiglio\BCMathExtended\Builders;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Interfaces\Builder;
use MarcoConsiglio\BCMathExtended\Number;

class FromFloat implements Builder
{
    /**
     * The numeric float input.
     */
    protected float $number;

    /**
     * The builder output.
     */
    protected BcMathNumber $bc_math_number;

    /**
     * Construct a Number Builder accepting a float type input.
     */
    public function __construct(float $number)
    {
        $this->number = $number;
    }

    /**
     * Validate input.
     */
    protected function validate(): void
    {
        $this->bc_math_number = new BcMathNumber(
            Number::string($this->number)
        );
    }

    /**
     * Get the builder output.
     */
    public function getResult(): BcMathNumber
    {
        $this->validate();
        return $this->bc_math_number;
    }
}