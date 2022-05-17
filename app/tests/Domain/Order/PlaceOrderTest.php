<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Order;

use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\PlaceOrder;
use PHPUnit\Framework\TestCase;

class PlaceOrderTest extends TestCase
{
    /** @test */
    public function it_has_order_data(): void
    {
        $orderId = new Id('00000000-0000-0000-0000-000000000001');
        $placedAt = new \DateTimeImmutable();

        $placeOrder = new PlaceOrder(
            $orderId,
            $placedAt
        );

        $this->assertEquals($orderId, $placeOrder->orderId);
        $this->assertEquals($placedAt, $placeOrder->placedAt);
    }
}
