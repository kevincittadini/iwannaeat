<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Order;

use Broadway\Serializer\Serializable;
use IWannaEat\Domain\Id;

/**
 * @psalm-type OrderPlacedData = array{orderId: string, placedAt: string}
 */
final class OrderPlaced implements Serializable
{
    public function __construct(
        public readonly Id $orderId,
        public readonly \DateTimeImmutable $placedAt
    ) {
    }

    public static function deserialize(array $data): static
    {
        /**
         * @psalm-var OrderPlacedData $data
         */
        return new static(
            new Id($data['orderId']),
            new \DateTimeImmutable($data['placedAt'])
        );
    }

    /**
     * @psalm-return OrderPlacedData
     */
    public function serialize(): array
    {
        return [
            'orderId' => (string) $this->orderId,
            'placedAt' => $this->placedAt->format(\DateTime::ATOM),
        ];
    }
}
