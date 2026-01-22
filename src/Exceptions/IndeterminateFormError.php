<?php
namespace MarcoConsiglio\BCMathExtended\Exceptions;

use ArithmeticError;

class IndeterminateFormError extends ArithmeticError
{
    public function __construct(string $expression)
    {
        return parent::__construct(
            "Cannot calculate the expression $expression."
        );
    }
}