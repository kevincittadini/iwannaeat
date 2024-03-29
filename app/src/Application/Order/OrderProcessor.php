<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\Processor\Processor;
use IWannaEat\Domain\Order\OrderPlaced;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class OrderProcessor extends Processor
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    protected function handleOrderPlaced(OrderPlaced $orderPlaced): void
    {
        $email = (new Email())
            ->subject('Nuovo ordine IWannaEat eseguito!')
            ->from('iwannaeat@example.com')
            ->to($orderPlaced->customer->emailAddress->toString())
            ->html(sprintf("<h2>Nuovo ordine eseguito!</h2><p>Ti confermiamo che hai eseguito l'ordine ID %s</p>", (string) $orderPlaced->orderId))
            ->text(sprintf("Nuovo ordine eseguito! Ti confermiamo che hai eseguito l'ordine ID %s", (string) $orderPlaced->orderId));

        $this->mailer->send($email);
    }
}
