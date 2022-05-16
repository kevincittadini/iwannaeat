<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain;

use IWannaEat\Domain\IdGenerator;
use IWannaEat\Domain\Id;
use PHPUnit\Framework\TestCase;

class IdGeneratorTest extends TestCase
{
    private IdGenerator $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = new IdGenerator();
    }

    /** @test */
    public function it_generates_valid_uuids(): void
    {
        $id = $this->idGenerator->generate();
        $this->assertInstanceOf(Id::class, $id);
    }
}
