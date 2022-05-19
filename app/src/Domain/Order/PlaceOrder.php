<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Order;

use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Product\ProductList;

final class PlaceOrder
{
    public function __construct(
        public readonly Id $orderId,
        public readonly Customer $customer,
        public readonly ProductList $productList,
        public readonly \DateTimeImmutable $placedAt
    ) {
    }
}
