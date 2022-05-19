<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Product;

use IWannaEat\Domain\Id;
use IWannaEat\Domain\SimpleEntity;
use Money\Currency;
use Money\Money;

final class Product implements SimpleEntity
{
    public function __construct(
        public readonly Id $id,
        public readonly string $name,
        public readonly Money $price
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public static function deserialize(array $data): self
    {
        return new Product(
            new Id($data['id']),
            $data['name'],
            new Money($data['price']['amount'], new Currency($data['price']['currency']))
        );
    }

    public function serialize(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'price' => $this->price->jsonSerialize(),
        ];
    }
}
