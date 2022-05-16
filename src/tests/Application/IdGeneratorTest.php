<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application;

use Assert\Assertion;
use IWannaEat\Application\IdGenerator;
use PHPUnit\Framework\TestCase;

class IdGeneratorTest extends TestCase
{
    /** @test */
    public function it_generates_valid_uuids(): void
    {
        $this->assertTrue(
            Assertion::uuid(
                (new IdGenerator())->generate()
            )
        );
    }
}
