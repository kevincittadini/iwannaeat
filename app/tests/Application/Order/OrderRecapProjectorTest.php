<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use IWannaEat\Application\Order\OrderRecapModel;
use IWannaEat\Application\Order\OrderRecapProjector;
use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Product\Product;
use IWannaEat\Domain\Product\ProductList;
use Money\Money;

class OrderRecapProjectorTest extends ProjectorScenarioTestCase
{
    /** @test */
    public function it_projects_order_placed(): void
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
