<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use IWannaEat\Application\Order\OrderRecapModel;
use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Product\Product;
use IWannaEat\Domain\Product\ProductList;
use Money\Money;
use PHPUnit\Framework\TestCase;

class OrderRecapModelTest extends TestCase
{
    private array $orderRecapData;
    private array $orderPlacedData;

    protected function setUp(): void
    {
        parent::setUp();

        $placedAt = (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM);
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

        $this->orderRecapData = [
            'id' => '00000000-0000-0000-0000-000000000001',
            'customer' => $customer->serialize(),
            'productList' => $productList->serialize(),
            'placedAt' => $placedAt,
        ];

        $this->orderPlacedData = [
            'orderId' => '00000000-0000-0000-0000-000000000001',
            'customer' => $customer->serialize(),
            'productList' => $productList->serialize(),
            'placedAt' => $placedAt,
        ];
    }

    /** @test */
    public function it_deserialize_data(): void
    {
        $orderRecap = OrderRecapModel::deserialize($this->orderRecapData);

        $this->assertEquals(new Id($this->orderRecapData['id']), $orderRecap->id);
        $this->assertEquals(Customer::deserialize($this->orderRecapData['customer']), $orderRecap->customer);
        $this->assertEquals(ProductList::deserialize($this->orderRecapData['productList']), $orderRecap->productList);
        $this->assertEquals(new \DateTimeImmutable($this->orderRecapData['placedAt']), $orderRecap->placedAt);
    }

    /** @test */
    public function it_serialize_data(): void
    {
        $this->assertSame(
            $this->orderRecapData,
            OrderRecapModel::deserialize($this->orderRecapData)->serialize()
        );
    }

    /** @test */
    public function it_inits_read_model_from_order_placed_event(): void
    {
        $orderPlaced = OrderPlaced::deserialize($this->orderPlacedData);
        $order = OrderRecapModel::fromOrderPlaced($orderPlaced);

        $this->assertEquals($orderPlaced->orderId, $order->id);
        $this->assertEquals($orderPlaced->customer, $order->customer);
        $this->assertEquals($orderPlaced->productList, $order->productList);
        $this->assertEquals($orderPlaced->placedAt, $order->placedAt);
    }
}
