<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Application\Order;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use IWannaEat\Application\Order\OrderHandler;

class OrderHandlerTest extends CommandHandlerScenarioTestCase
{
    public function it_places_order(): void
    {

    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new OrderHandler(
        );
    }
}
