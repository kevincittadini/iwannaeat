<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Order;

use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\PlaceOrder;
use IWannaEat\Domain\Product\Product;
use IWannaEat\Domain\Product\ProductList;
use Money\Money;
use PHPUnit\Framework\TestCase;

class PlaceOrderTest extends TestCase
{
    /** @test */
    public function it_has_order_data(): void
    {
        $orderId = new Id('00000000-0000-0000-0000-000000000001');
        $placedAt = new \DateTimeImmutable();
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

        $placeOrder = new PlaceOrder(
            $orderId,
            $customer,
            $productList,
            $placedAt
        );

        $this->assertEquals($orderId, $placeOrder->orderId);
        $this->assertEquals($customer, $placeOrder->customer);
        $this->assertEquals($productList, $placeOrder->productList);
        $this->assertEquals($placedAt, $placeOrder->placedAt);
    }
}
