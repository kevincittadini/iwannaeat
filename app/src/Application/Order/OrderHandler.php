<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\CommandHandling\SimpleCommandHandler;
use IWannaEat\Domain\Order\Order;
use IWannaEat\Domain\Order\PlaceOrder;

final class OrderHandler extends SimpleCommandHandler
{
    public function __construct(
        private OrderAggregateRepository $orderRepository
    ) {
    }

    public function handlePlaceOrder(PlaceOrder $placeOrder): void
    {
        $order = Order::placeOrder($placeOrder);

        $this->orderRepository->save($order);
    }
}
