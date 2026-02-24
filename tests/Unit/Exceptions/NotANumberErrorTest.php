<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Unit\Exceptions;

use MarcoConsiglio\BCMathExtended\Exceptions\NotANumberError;
use MarcoConsiglio\BCMathExtended\Tests\BaseTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The NotANumberError")]
#[CoversClass(NotANumberError::class)]
class NotANumberErrorTest extends BaseTestCase
{
    #[TestDox("is thrown when an arithmetic calculations do not result in a number.")]
    public function test_exception_message(): void
    {
        // Arrange
        $expression = "10.4!";
        $error = new NotANumberError($expression);

        // Act & Assert
        $this->assertEquals($error->getMessage(), "Cannot calculate the expression $expression.");
    }
}