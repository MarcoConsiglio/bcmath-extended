<?php
namespace MarcoConsiglio\BCMathExtended\Builders;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Interfaces\Builder;

class FromInt implements Builder
{
    /**
     * The integer input.
     */
    protected int $number;

    /**
     * The output of the builder.
     */
    protected BcMathNumber $bc_math_number;

    /**
     * Construct a Number Builder accepting an int type input.
     */
    public function __construct(int $number)
    {
        $this->number = $number;
    }

    /**
     * Validate input.
     */
    protected function validate(): void
    {
        $this->bc_math_number = new BcMathNumber($this->number);
    }

    /**
     * Get the output of the builder.
     */
    public function getResult(): BcMathNumber
    {
        $this->validate();
        return $this->bc_math_number;
    }
}