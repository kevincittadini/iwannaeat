<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Order;

use IWannaEat\Domain\Id;

final class PlaceOrder
{
    public function __construct(
        public readonly Id $orderId,
        public readonly \DateTimeImmutable $placedAt
    ) {
    }
}
