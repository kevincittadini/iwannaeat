<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;
use IWannaEat\Domain\Order\OrderPlaced;

final class OrderRecapProjector extends Projector
{
    public function __construct(
        private Repository $repository
    ) {
    }

    public function applyOrderPlaced(OrderPlaced $orderPlaced): void
    {
        $this->repository->save(
            OrderRecapModel::fromOrderPlaced($orderPlaced)
        );
    }
}
