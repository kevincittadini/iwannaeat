<?php

declare(strict_types=1);


namespace IWannaEat\Application\Product;

use IWannaEat\Domain\Product\ProductList;

final class ProductListGenerator
{
    public function __construct(
        private ProductGeneratorInterface $productGenerator
    ){
    }

    public function generate(): ProductList
    {
        $howManyProds = random_int(1, 5);

        $products = [];

        while($howManyProds > 0) {
            $products[] = $this->productGenerator->generate();
            $howManyProds--;
        }

        return new ProductList($products);
    }
}
