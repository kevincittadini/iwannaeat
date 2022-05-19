<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Product;

use Assert\Assertion;
use IWannaEat\Application\IdGeneratorInterface;
use IWannaEat\Application\Product\ProductGenerator;
use IWannaEat\Domain\Id;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Ramsey\Uuid\Uuid;

class ProductGeneratorTest extends TestCase
{
    use ProphecyTrait;

    private $idGenerator;
    private ProductGenerator $productGenerator;

    protected function setUp(): void
    {
        $this->idGenerator = $this->prophesize(IdGeneratorInterface::class);

        $this->productGenerator = new ProductGenerator($this->idGenerator->reveal());
    }

    /** @test */
    public function it_generates_random_products(): void
    {
        $iterations = 100;

        while ($iterations > 0) {
            $id = new Id(Uuid::uuid4()->toString());
            $this->idGenerator->generate()
                ->shouldBeCalled(1)
                ->willReturn($id);

            $product = $this->productGenerator->generate();

            $this->assertTrue(Assertion::uuid($product->id));
            $this->assertIsString($product->name);
            $this->assertIsNumeric($product->price->getAmount());

            $iterations--;
        }
    }
}
