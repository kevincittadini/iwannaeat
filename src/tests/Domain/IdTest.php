<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain;

use IWannaEat\Domain\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    private string $id;

    protected function setUp(): void
    {
        parent::setUp();
        $this->id = '00000000-0000-0000-0000-000000000001';
    }

    /** @test */
    public function it_holds_correct_value(): void
    {
        $this->assertSame($this->id, (new Id($this->id))->value);
    }

    /** @test */
    public function it_can_be_converted_to_string(): void
    {
        $this->assertSame($this->id, sprintf('%s', new Id($this->id)));
    }
}
