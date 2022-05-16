<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Order;

use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use PHPUnit\Framework\TestCase;

class OrderPlacedTest extends TestCase
{
    private Id $orderId;
    private \DateTimeImmutable $placedAt;
    private OrderPlaced $orderPlaced;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderId = new Id('00000000-0000-0000-0000-000000000001');
        $this->placedAt = new \DateTimeImmutable('2022-05-10T20:10:00');

        $this->orderPlaced = new OrderPlaced(
            $this->orderId,
            $this->placedAt
        );
    }

    /** @test */
    public function it_holds_order_placing_data(): void
    {
        $this->assertEquals($this->orderId, $this->orderPlaced->orderId);
        $this->assertEquals($this->placedAt, $this->orderPlaced->placedAt);
    }

    /** @test */
    public function it_serializes_data(): void
    {
        $expected = [
            'orderId' => (string)$this->orderId,
            'placedAt' => $this->placedAt->format(\DateTimeInterface::ATOM)
        ];

        $actual = $this->orderPlaced->serialize();

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_deserializes_event(): void
    {
        $actual = OrderPlaced::deserialize([
            'orderId' => (string)$this->orderId,
            'placedAt' => $this->placedAt->format(\DateTimeInterface::ATOM)
        ]);

        $this->assertEquals($this->orderPlaced, $actual);
    }
}
