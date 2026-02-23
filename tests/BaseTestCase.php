<?php
namespace MarcoConsiglio\BCMathExtended\Tests;

use MarcoConsiglio\BCMathExtended\Number;
use BcMath\Number as BcMathNumber;
use MarcoConsiglio\BCMathExtended\Tests\Traits\WithDataProviders;
use MarcoConsiglio\FakerPhpNumberHelpers\WithFakerHelpers;
use Override;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    use WithDataProviders;

    /**
     * This method is called before each test.
     */
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    /**
     * Instantiate a BcMathExtended\Number class from an int, string or
     * BcMath\Number instance, is is not already a BcMathExtended\Number
     * instance.
     * 
     * @param int|string|BcMathNumber|Number $number
     */
    protected function instantiateNumber(mixed $number): Number
    {
        return $number instanceof Number ? $number : new Number($number);
    }

    /**
     * Instantiate an array of BcMathExtended\Number instances.
     * 
     * @param int[]|string[]|BcMathNumber[]|Number[] $numbers
     * @return Number[]
     */
    protected function instantiateNumbers(array $numbers): array
    {
        foreach ($numbers as $index => $number) {
            $numbers[$index] = $this->instantiateNumber($number);
        }
        return $numbers;
    }

    /**
     * Get a congruent integer number to $value modulo $modulus multiplied
     * by $k.
     */
    protected static function getCongruentIntegerValue(int $value, int $modulus, int $k): int
    {
        $reminder = $value % $modulus;
        $congruent_value = $k * $modulus + $reminder;
        if ($congruent_value > PHP_INT_MAX || $congruent_value < PHP_INT_MIN) return $reminder;
        return $congruent_value % $modulus;
    }

    /**
     * Return an error message for the operation max($vars) = $max.
     */
    protected function getMaxErrorMessage(mixed $vars, mixed $max): string
    {
        return $this->getMinOrMaxErrorMessage("max", $vars, $max);
    }

    /**
     * Return an error message for the operation min($vars) = $min.
     */   
    protected function getMinErrorMessage(mixed $vars, mixed $min): string
    {
        return $this->getMinOrMaxErrorMessage("min", $vars, $min);
    }

    /**
     * Return an error message for the operation max or min.
     */
    private function getMinOrMaxErrorMessage(string $min_or_max, mixed $vars, mixed $result): string
    {
        if ($min_or_max != "min" && $min_or_max != "max") $min_or_max = "max";
        $message = "$min_or_max(";
        $count = count($vars);
        for ($i = 0; $i <= $count - 1; $i++) {
            if ($i == $count - 1) {
                $message .= $vars[$i].")";
            } else $message .= $vars[$i].", ";
        }
        $message .= " = $result";
        return $message;       
    }
}