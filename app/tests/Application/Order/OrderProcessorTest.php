<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use Broadway\Processor\Processor;
use IWannaEat\Application\Order\OrderProcessor;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Tests\Application\ProcessorTestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;

class OrderProcessorTest extends ProcessorTestCase
{
    use ProphecyTrait;

    /** @var MailerInterface */
    private $mailer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mailer = $this->prophesize(MailerInterface::class);
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

        $this->mailer->send(new RawMessage('Order placed!! Yahoo!'))->shouldBeCalled();

        $this->handleEvent($orderPlaced);
    }

    protected function registerProcessor(): Processor
    {
        return new OrderProcessor($this->mailer->reveal());
    }
}
