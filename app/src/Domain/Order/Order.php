<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Order;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Product\ProductList;

/** @psalm-suppress PropertyNotSetInConstructor */
final class Order extends EventSourcedAggregateRoot
{
    private Id $orderId;
    private \DateTimeImmutable $placedAt;
    private Customer $customer;
    private ProductList $productList;

    private function __construct()
    {
    }

    public static function placeOrder(PlaceOrder $placeOrder): self
    {
        $order = new self();

        $order->apply(new OrderPlaced(
            $placeOrder->orderId,
            $placeOrder->customer,
            $placeOrder->productList,
            $placeOrder->placedAt
        ));

        return $order;
    }

    public function applyOrderPlaced(OrderPlaced $orderPlaced): void
    {
        $this->orderId = $orderPlaced->orderId;
        $this->customer = $orderPlaced->customer;
        $this->productList = $orderPlaced->productList;
        $this->placedAt = $orderPlaced->placedAt;
    }

    public function getAggregateRootId(): string
    {
        return (string) $this->orderId;
    }
}
