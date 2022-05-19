<?php

declare(strict_types=1);

namespace IWannaEat\Application\Product;

use IWannaEat\Application\IdGeneratorInterface;
use IWannaEat\Domain\Product\Product;
use Money\Money;

final class ProductGenerator implements ProductGeneratorInterface
{
    /** @var string[] */
    private array $productNamesRepository;
    private IdGeneratorInterface $idGenerator;

    public function __construct(IdGeneratorInterface $idGenerator)
    {
        $this->idGenerator = $idGenerator;
        $this->productNamesRepository = [
            'Hamburger', 'Chips', 'Fish + Chips', 'French Fries', 'Pizza',
            'Taco', 'Nachos', 'Steak', 'Pasta', 'Eggs + Bacon',
        ];
    }

    public function generate(): Product
    {
        return new Product(
            $this->idGenerator->generate(),
            $this->generateProductName(),
            $this->generatePrice()
        );
    }

    private function generateProductName(): string
    {
        return $this->productNamesRepository[random_int(0, count($this->productNamesRepository) - 1)];
    }

    private function generatePrice(): Money
    {
        return Money::EUR(random_int(10, 50));
    }
}
