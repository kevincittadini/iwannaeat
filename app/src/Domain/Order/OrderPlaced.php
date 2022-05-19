<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Order;

use Broadway\Serializer\Serializable;
use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Product\ProductList;

/**
 * @psalm-type OrderPlacedData = array{orderId: string, customer: array, productList: array, placedAt: string}
 */
final class OrderPlaced implements Serializable
{
    public function __construct(
        public readonly Id $orderId,
        public readonly Customer $customer,
        public readonly ProductList $productList,
        public readonly \DateTimeImmutable $placedAt
    ) {
    }

    public static function deserialize(array $data): self
    {
        /**
         * @psalm-var OrderPlacedData $data
         */
        return new self(
            new Id($data['orderId']),
            Customer::deserialize($data['customer']),
            ProductList::deserialize($data['productList']),
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
            'customer' => $this->customer->serialize(),
            'productList' => $this->productList->serialize(),
            'placedAt' => $this->placedAt->format(\DateTime::ATOM),
        ];
    }
}
