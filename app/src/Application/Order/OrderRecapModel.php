<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\ReadModel\SerializableReadModel;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-immutable
 * @psalm-type OrderRecapModelData = array{orderId: string, placedAt: string}
 */
final class OrderRecapModel implements SerializableReadModel
{
    public Id $orderId; // @todo: set readonly attribute when Psalm fixes PHP8.1 support. Fallback to @psalm-immutable.
    public \DateTimeImmutable $placedAt;

    private function __construct()
    {
    }

    public function getId(): string
    {
        return (string) $this->orderId;
    }

    public static function fromOrderPlaced(OrderPlaced $orderPlaced): self
    {
        $order = new self();

        $order->orderId = $orderPlaced->orderId;
        $order->placedAt = $orderPlaced->placedAt;

        return $order;
    }

    public static function deserialize(array $data): self
    {
        /** @psalm-var OrderRecapModelData $data */
        $order = new self();

        $order->orderId = new Id($data['orderId']);
        $order->placedAt = new \DateTimeImmutable($data['placedAt']);

        return $order;
    }

    /** @psalm-return OrderRecapModelData */
    public function serialize(): array
    {
        return [
            'orderId' => (string) $this->orderId,
            'placedAt' => $this->placedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
