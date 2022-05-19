<?php

declare(strict_types=1);


namespace IWannaEat\Application\Product;

use IWannaEat\Domain\Product\Product;

interface ProductGeneratorInterface
{
    public function generate(): Product;
}
