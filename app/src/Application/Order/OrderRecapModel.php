<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\ReadModel\SerializableReadModel;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-immutable
 * @psalm-type OrderRecapModelData = array{id: string, placedAt: string}
 */
final class OrderRecapModel implements SerializableReadModel
{
    public Id $id; // @todo: set readonly attribute when Psalm fixes PHP8.1 support. Fallback to @psalm-immutable.
    public \DateTimeImmutable $placedAt; // @todo: set readonly attribute when Psalm fixes PHP8.1 support. Fallback to @psalm-immutable.

    private function __construct()
    {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public static function fromOrderPlaced(OrderPlaced $orderPlaced): self
    {
        $order = new self();

        $order->id = $orderPlaced->orderId;
        $order->placedAt = $orderPlaced->placedAt;

        return $order;
    }

    public static function deserialize(array $data): self
    {
        /** @psalm-var OrderRecapModelData $data */
        $order = new self();

        $order->id = new Id($data['id']);
        $order->placedAt = new \DateTimeImmutable($data['placedAt']);

        return $order;
    }

    /** @psalm-return OrderRecapModelData */
    public function serialize(): array
    {
        return [
            'id' => (string) $this->id,
            'placedAt' => $this->placedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
