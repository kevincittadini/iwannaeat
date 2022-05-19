<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use Broadway\Processor\Processor;
use IWannaEat\Application\Order\OrderProcessor;
use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Product\Product;
use IWannaEat\Domain\Product\ProductList;
use IWannaEat\Tests\Application\ProcessorTestCase;
use Money\Money;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
        $customer = new Customer(
            new Id('00000000-0000-0000-0000-000000000011'),
            new CustomerName('Rossi', 'Mario'),
            new EmailAddress('test@example.com'),
        );
        $productList = new ProductList([
            new Product(
                new Id('00000000-0000-0000-0000-000000000002'),
                'P1',
                Money::EUR(123)
            ),
            new Product(
                new Id('00000000-0000-0000-0000-000000000003'),
                'P1',
                Money::EUR(123)
            ),
            new Product(
                new Id('00000000-0000-0000-0000-000000000004'),
                'P1',
                Money::EUR(123)
            ),
        ]);

        $orderPlaced = new OrderPlaced(
            $orderId,
            $customer,
            $productList,
            $placedAt
        );

        $email = (new Email())
            ->subject('Nuovo ordine IWannaEat eseguito!')
            ->from('iwannaeat@example.com')
            ->to($customer->emailAddress->toString())
            ->html(sprintf("<h2>Nuovo ordine eseguito!</h2><p>Ti confermiamo che hai eseguito l'ordine ID %s</p>", $orderPlaced->orderId))
            ->text(sprintf("Nuovo ordine eseguito! Ti confermiamo che hai eseguito l'ordine ID %s", $orderPlaced->orderId));

        $this->mailer->send($email)->shouldBeCalled();

        $this->handleEvent($orderPlaced);
    }

    protected function registerProcessor(): Processor
    {
        return new OrderProcessor($this->mailer->reveal());
    }
}
