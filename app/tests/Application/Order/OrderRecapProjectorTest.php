<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use IWannaEat\Application\Order\OrderRecapModel;
use IWannaEat\Application\Order\OrderRecapProjector;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;

class OrderRecapProjectorTest extends ProjectorScenarioTestCase
{
    /** @test */
    public function it_projects_order_placed(): void
    {
        $orderId = new Id('00000000-0000-0000-0000-000000000001');
        $placedAt = new \DateTimeImmutable('2022-05-10T20:10:00');

        $orderPlaced = new OrderPlaced(
            $orderId,
            $placedAt
        );

        $orderRecap = OrderRecapModel::fromOrderPlaced($orderPlaced);

        $this->scenario
            ->when($orderPlaced)
            ->then([$orderRecap]);
    }

    protected function createProjector(InMemoryRepository $repository): Projector
    {
        return new OrderRecapProjector($repository);
    }
}
