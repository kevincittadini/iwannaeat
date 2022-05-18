<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use IWannaEat\Application\Order\OrderRecapModel;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use PHPUnit\Framework\TestCase;

class OrderRecapModelTest extends TestCase
{
    private array $orderRecapData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRecapData = [
            'orderId' => '00000000-0000-0000-0000-000000000001',
            'placedAt' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
        ];
    }

    /** @test */
    public function it_deserialize_data(): void
    {
        $orderRecap = OrderRecapModel::deserialize($this->orderRecapData);

        $this->assertEquals(new Id($this->orderRecapData['orderId']), $orderRecap->orderId);
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
        $orderPlaced = OrderPlaced::deserialize($this->orderRecapData);
        $order = OrderRecapModel::fromOrderPlaced($orderPlaced);

        $this->assertEquals($orderPlaced->orderId, $order->orderId);
        $this->assertEquals($orderPlaced->placedAt, $order->placedAt);
    }
}
