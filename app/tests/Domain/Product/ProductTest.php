<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Product;

use IWannaEat\Domain\Id;
use IWannaEat\Domain\Product\Product;
use Money\Money;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /** @test */
    public function it_holds_product_data(): void
    {
        $id = new Id('00000000-0000-0000-0000-000000000001');
        $name = 'Prod 1';
        $price = Money::EUR('123');

        $product = new Product(
            $id,
            $name,
            $price
        );

        $this->assertEquals($id, $product->id);
        $this->assertEquals($name, $product->name);
        $this->assertEquals($price, $product->price);
    }

    /** @test  */
    public function it_serializes_product_data(): void
    {
        $id = new Id('00000000-0000-0000-0000-000000000001');
        $name = 'Prod 1';
        $price = Money::EUR(123);

        $product = new Product(
            $id,
            $name,
            $price
        );

        $expected = [
            'id' => (string)$id,
            'name' => $name,
            'price' => $price->jsonSerialize(),
        ];

        $actual = $product->serialize();

        $this->assertEquals($expected, $actual);
    }
}
