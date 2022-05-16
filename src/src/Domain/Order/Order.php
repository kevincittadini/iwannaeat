<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Order;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use IWannaEat\Domain\Id;

/** @psalm-suppress MissingConstructor */
final class Order extends EventSourcedAggregateRoot
{
    private Id $orderId;
    private \DateTimeImmutable $placedAt;

    public static function placeOrder(PlaceOrder $placeOrder): self
    {
        $order = new self();

        $order->apply(new OrderPlaced(
            $placeOrder->orderId,
            $placeOrder->placedAt
        ));

        return $order;
    }

    public function applyOrderPlaced(OrderPlaced $orderPlaced): void
    {
        $this->orderId = $orderPlaced->orderId;
        $this->placedAt = $orderPlaced->placedAt;
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->orderId;
    }
}
