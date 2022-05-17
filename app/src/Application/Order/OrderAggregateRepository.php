<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventSourcing\EventStreamDecorator;
use Broadway\EventStore\EventStore;
use IWannaEat\Domain\Order\Order;

final class OrderAggregateRepository extends EventSourcingRepository
{
    /** @psalm-param array<array-key, EventStreamDecorator> $eventStreamDecorators */
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        string $aggregateClass,
        AggregateFactory $aggregateFactory,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            Order::class,
            $aggregateFactory,
            $eventStreamDecorators
        );
    }
}
