<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Order;

use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Product\Product;
use IWannaEat\Domain\Product\ProductList;
use Money\Money;
use PHPUnit\Framework\TestCase;

class OrderPlacedTest extends TestCase
{
    private Id $orderId;
    private \DateTimeImmutable $placedAt;
    private OrderPlaced $orderPlaced;
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

        $this->orderPlaced = new OrderPlaced(
            $this->orderId,
            $this->customer,
            $this->productList,
            $this->placedAt
        );
    }

    /** @test */
    public function it_holds_order_placing_data(): void
    {
        $this->assertEquals($this->orderId, $this->orderPlaced->orderId);
        $this->assertEquals($this->customer, $this->orderPlaced->customer);
        $this->assertEquals($this->productList, $this->orderPlaced->productList);
        $this->assertEquals($this->placedAt, $this->orderPlaced->placedAt);
    }

    /** @test */
    public function it_serializes_data(): void
    {
        $expected = [
            'orderId' => (string)$this->orderId,
            'customer' => $this->customer->serialize(),
            'productList' => $this->productList->serialize(),
            'placedAt' => $this->placedAt->format(\DateTimeInterface::ATOM)
        ];

        $actual = $this->orderPlaced->serialize();

        $this->assertSame($expected, $actual);
    }

    /** @test */
    public function it_deserializes_event(): void
    {
        $actual = OrderPlaced::deserialize([
            'orderId' => (string)$this->orderId,
            'customer' => $this->customer->serialize(),
            'productList' => $this->productList->serialize(),
            'placedAt' => $this->placedAt->format(\DateTimeInterface::ATOM)
        ]);

        $this->assertEquals($this->orderPlaced, $actual);
    }
}
