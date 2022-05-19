<?php

declare(strict_types=1);

namespace IWannaEat\Application\Order;

use Broadway\ReadModel\SerializableReadModel;
use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\Order\OrderPlaced;
use IWannaEat\Domain\Product\ProductList;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 * @psalm-immutable
 * @psalm-type OrderRecapModelData = array{id: string, placedAt: string}
 */
final class OrderRecapModel implements SerializableReadModel
{
    // @todo: set `readonly` attributes when Psalm fixes PHP8.1 support. Fallback to @psalm-immutable.
    public Id $id;
    public Customer $customer;
    public ProductList $productList;
    public \DateTimeImmutable $placedAt;

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
        $order->customer = $orderPlaced->customer;
        $order->productList = $orderPlaced->productList;
        $order->placedAt = $orderPlaced->placedAt;

        return $order;
    }

    public static function deserialize(array $data): self
    {
        /** @psalm-var OrderRecapModelData $data */
        $order = new self();

        $order->id = new Id($data['id']);
        $order->customer = Customer::deserialize($data['customer']);
        $order->productList = ProductList::deserialize($data['productList']);
        $order->placedAt = new \DateTimeImmutable($data['placedAt']);

        return $order;
    }

    /** @psalm-return OrderRecapModelData */
    public function serialize(): array
    {
        return [
            'id' => (string) $this->id,
            'customer' => $this->customer->serialize(),
            'productList' => $this->productList->serialize(),
            'placedAt' => $this->placedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
