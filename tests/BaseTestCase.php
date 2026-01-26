<?php
namespace MarcoConsiglio\BCMathExtended\Tests;

use MarcoConsiglio\BCMathExtended\Tests\Traits\WithDataProviders;
use Override;
use PHPUnit\Framework\TestCase;
use MarcoConsiglio\BCMathExtended\Tests\Traits\WithFaker;

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
}