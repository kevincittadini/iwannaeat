<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Order;

use IWannaEat\Application\Order\OrderRecapModel;
use IWannaEat\Domain\Id;
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
}
