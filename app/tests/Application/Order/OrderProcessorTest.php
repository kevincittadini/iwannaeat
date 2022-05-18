<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use Broadway\Processor\Processor;
use IWannaEat\Application\Order\OrderProcessor;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Tests\Application\ProcessorTestCase;

class OrderProcessorTest extends ProcessorTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_sends_email_on_order_placement(): void
    {
        $orderId = new Id('00000000-0000-0000-0000-000000000001');
        $placedAt = new \DateTimeImmutable('2022-05-10T20:10:00');

        $orderPlaced = new OrderPlaced(
            $orderId,
            $placedAt
        );

        $this->handleEvent($orderPlaced);
    }

    protected function registerProcessor(): Processor
    {
        return new OrderProcessor();
    }
}
