<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Domain\Product;

use IWannaEat\Domain\Id;
use IWannaEat\Domain\Product\Product;
use IWannaEat\Domain\Product\ProductList;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductListTest extends TestCase
{
    private Product $p1;
    private Product $p2;
    private Product $p3;
    private ProductList $productList;

    protected function setUp(): void
    {
        $this->p1 = new Product(
            new Id(Uuid::uuid4()->toString()),
            'P1',
            Money::EUR(123)
        );

        $this->p2 = new Product(
            new Id(Uuid::uuid4()->toString()),
            'P2',
            Money::EUR(312)
        );

        $this->p3 = new Product(
            new Id(Uuid::uuid4()->toString()),
            'P3',
            Money::EUR(321)
        );

        $this->productList = new ProductList([$this->p1, $this->p2, $this->p3]);
    }

    /** @test */
    public function it_holds_a_list_of_products(): void
    {
        $this->assertEquals([$this->p1, $this->p2, $this->p3], $this->productList->products);
    }

    /** @test */
    public function it_serializes(): void
    {
        $expected = [
            $this->p1->serialize(),
            $this->p2->serialize(),
            $this->p3->serialize()
        ];

        $actual = $this->productList->serialize();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function it_deserialize(): void
    {
        $data = [
            $this->p1->serialize(),
            $this->p2->serialize(),
            $this->p3->serialize()
        ];

        $this->assertEquals($this->productList, ProductList::deserialize($data));
    }
}
