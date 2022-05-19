<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Product;

use Broadway\Serializer\Serializable;

/**
 * @psalm-import-type ProductData from Product
 * @psalm-type ProductListData = array<ProductData>
 */
final class ProductList implements Serializable
{
    /**
     * @param array<Product> $products
     */
    public function __construct(
        public readonly array $products
    ) {
    }

    public static function deserialize(array $data): self
    {
        /** @psalm-var ProductListData $data */
        $productList = [];

        foreach ($data as $product) {
            $productList[] = Product::deserialize($product);
        }

        return new self($productList);
    }

    /** @psalm-return ProductListData */
    public function serialize(): array
    {
        $productList = [];

        foreach ($this->products as $product) {
            $productList[] = $product->serialize();
        }

        return $productList;
    }
}
