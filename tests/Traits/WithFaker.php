<?php
namespace MarcoConsiglio\BCMathExtended\Tests\Traits;

use Faker\Factory;
use Faker\Generator;

/**
 * FakerPHP support.
 */
trait WithFaker
{
    /**
     * The FakerPHP random generator.
     */
    protected static Generator $faker;

    /**
     * Set up the FakerPHP generator.
     */
    protected static function setUpFaker(): void
    {
        if (! isset(self::$faker))
            self::$faker = Factory::create(Factory::DEFAULT_LOCALE);
    }

    /**
     * Return a random relative integer.
     */
    protected static function randomInteger(int $min = 0, int $max = PHP_INT_MAX): int
    {
        $value = self::$faker->numberBetween($min, $max);
        return self::$faker->randomElement([$value, -$value]);
    }

    /**
     * Return a random positive integer.
     */
    protected static function positiveRandomInteger(int $min = 0, int $max = PHP_INT_MAX): int
    {
        if ($min < 0) $min = 0;
        if ($max < 0) $max = PHP_INT_MAX;
        return self::$faker->numberBetween($min, $max);
    }

    /**
     * Return a random negative integer.
     */
    protected static function negativeRandomInteger(int $min = 1, int $max = PHP_INT_MAX): int
    {
        if ($min < 1) $min = abs($min);
        if ($min == 0) $min = 1;
        if ($max < 0) $max = PHP_INT_MAX;
        return -1 * self::$faker->numberBetween($min, $max);
    }

    /**
     * Return a random positive integer except for zero.
     */
    protected static function positiveNonNullRandomInteger(int $min = 1, int $max = PHP_INT_MAX): int
    {
        if ($min < 1) $min = 1;
        if ($max < 0) $max = PHP_INT_MAX;
        return self::randomInteger($min, $max);
    }

    /**
     * Return a random integer except for zero.
     */
    protected static function nonZeroRandomInteger(int $min = 0, int $max = PHP_INT_MAX): int
    {
        do {
            $number = self::randomInteger($min, $max);
        } while ($number == 0);
        return $number;
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
     * Return a random relative float.
     */
    protected static function randomFloat(float $min = 0, float $max = PHP_FLOAT_MAX): float
    {
        $value = self::positiveRandomFloat($min, $max);
        return self::$faker->randomElement([$value, -$value]);
    }

    /**
     * Alias of randomFloat() method.
     */
    protected static function positiveRandomFloat(float $min = 0, float $max = PHP_FLOAT_MAX): float
    {
        return self::$faker->randomFloat(min: $min, max: $max);
    }

    /**
     * Return a negative random float.
     */
    protected static function negativeRandomFloat(float $min = 0, float $max = PHP_FLOAT_MAX): float
    {
        return -1 * self::randomFloat($min, $max);
    }

    /**
     * Return a random relative float except for zero.
     */
    protected static function nonZeroRandomFloat(float $min = PHP_FLOAT_MIN, float $max = PHP_FLOAT_MAX): float
    {
        if ($min <= 0) $min = 0;
        if ($max <= 0) $max = PHP_FLOAT_MAX;
        do {
            $number = self::randomFloat($min, $max);
        } while ($number == 0);
        return $number;
    }
}