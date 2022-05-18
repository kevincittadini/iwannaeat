<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\Processor\Processor;
use IWannaEat\Domain\Order\OrderPlaced;

final class OrderProcessor extends Processor
{
    protected function handleOrderPlaced(OrderPlaced $orderPlaced): void
    {

    }
}
