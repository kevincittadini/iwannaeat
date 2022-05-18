<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\Processor\Processor;
use IWannaEat\Domain\Order\OrderPlaced;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;

final class OrderProcessor extends Processor
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    protected function handleOrderPlaced(OrderPlaced $orderPlaced): void
    {
        $this->mailer->send(new RawMessage('Order placed!! Yahoo!'));
    }
}
