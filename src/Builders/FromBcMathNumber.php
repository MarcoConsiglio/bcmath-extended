<?php
namespace MarcoConsiglio\BCMathExtended\Builders;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Interfaces\Builder;
use MarcoConsiglio\BCMathExtended\Number;

class FromBcMathNumber implements Builder
{
    /**
     * The BcMath\Number input and output.
     */
    protected BcMathNumber $number;

    /**
     * Construct a Number Builder accepting a float type input.
     */
    public function __construct(BcMathNumber $number)
    {
        $this->number = $number;
    }

    /**
     * Validate input.
     */
    protected function validate(): void {}

    /**
     * Get the builder output.
     */
    public function getResult(): BcMathNumber
    {
        $this->validate();
        return $this->number;
    }
}