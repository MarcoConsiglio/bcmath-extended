<?php
namespace MarcoConsiglio\BCMathExtended\Exceptions;

use ArithmeticError;

/**
 * The error thrown when an arithmetic calculations do not result
 * in a number.
 */
class NotANumberError extends ArithmeticError
{
    public function __construct(string $expression)
    {
        return parent::__construct(
            "Cannot calculate the expression $expression."
        );
    }
}