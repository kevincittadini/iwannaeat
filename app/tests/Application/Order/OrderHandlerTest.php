<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Application\Order;

use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventStore\EventStore;
use IWannaEat\Application\Order\OrderAggregateRepository;
use IWannaEat\Application\Order\OrderHandler;
use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\Order;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Order\PlaceOrder;
use IWannaEat\Domain\Product\Product;
use IWannaEat\Domain\Product\ProductList;
use Money\Money;

class OrderHandlerTest extends CommandHandlerScenarioTestCase
{
    private Id $orderId;
    private \DateTimeImmutable $placedAt;
    private Customer $customer;
    private ProductList $productList;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderId = new Id('00000000-0000-0000-0000-000000000001');
        $this->placedAt = new \DateTimeImmutable('2022-05-10T20:10:00');
        $this->customer = new Customer(
            new Id('00000000-0000-0000-0000-000000000011'),
            new CustomerName('Rossi', 'Mario'),
            new EmailAddress('test@example.com'),
        );
        $this->productList = new ProductList([
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
    }

    /** @test */
    public function it_places_order(): void
    {
        $this->scenario
            ->when(new PlaceOrder(
                $this->orderId,
                $this->customer,
                $this->productList,
                $this->placedAt
            ))
            ->then([
                new OrderPlaced(
                    $this->orderId,
                    $this->customer,
                    $this->productList,
                    $this->placedAt
                )
            ]);
    }

    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new OrderHandler(
            new OrderAggregateRepository(
                $eventStore,
                $eventBus,
                Order::class,
                new PublicConstructorAggregateFactory()
            )
        );
    }
}
