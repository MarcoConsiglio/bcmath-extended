<?php
namespace MarcoConsiglio\BCMathExtended\Builders;

use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Interfaces\Builder;
use MarcoConsiglio\BCMathExtended\Number;
use ValueError;

class FromString implements Builder
{
    /**
     * The numeric string input.
     */
    protected string $number;

    /**
     * The builder output.
     */
    protected BcMathNumber $bc_math_number;

    /**
     * Construct a Number Builder accepting a numeric string type input.
     */
    public function __construct(string $number)
    {
        $this->number = $number;
    }

    /**
     * Validate input.
     * 
     * @throws ValueError if $this->number is string and not a well-formed 
     * BCMath numeric string.
     */
    protected function validate(): void
    {
        $this->bc_math_number = new BcMathNumber(
            Number::string($this->number)
        );
    }

    /**
     * Get the builder output.
     * 
     * @throws ValueError if $this->number is string and not a well-formed 
     * BCMath numeric string.
     */
    public function getResult(): BcMathNumber
    {
        $this->validate();
        return $this->bc_math_number;
    }
}