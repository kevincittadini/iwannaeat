<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Order;

use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\Order;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Order\PlaceOrder;

class OrderTest extends AggregateRootScenarioTestCase
{
    /**
     * @test
     */
    public function it_places_order(): void
    {
        $orderId = new Id('00000000-0000-0000-0000-000000000001');
        $placedAt = new \DateTimeImmutable();

        $placeOrder = new PlaceOrder(
            $orderId,
            $placedAt
        );

        $orderPlaced = new OrderPlaced(
            $orderId,
            $placedAt
        );

        $this->scenario
            ->when(function () use ($placeOrder) {
                return Order::placeOrder($placeOrder);
            })
            ->then([$orderPlaced]);
    }

    protected function getAggregateRootClass(): string
    {
        return Order::class;
    }
}
