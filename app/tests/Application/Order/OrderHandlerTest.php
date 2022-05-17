<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Application\Order;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use IWannaEat\Application\Order\OrderHandler;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Order\PlaceOrder;

class OrderHandlerTest extends CommandHandlerScenarioTestCase
{
    private Id $orderId;
    private \DateTimeImmutable $placedAt;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderId = new Id('00000000-0000-0000-0000-000000000001');
        $this->placedAt = new \DateTimeImmutable('2022-05-10T20:10:00');
    }

    /** @test */
    public function it_places_order(): void
    {
        $this->scenario
            ->when(new PlaceOrder(
                $this->orderId,
                $this->placedAt
            ))
            ->then([
                new OrderPlaced(
                    $this->orderId,
                    $this->placedAt
                )
            ]);
    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new OrderHandler();
    }
}
