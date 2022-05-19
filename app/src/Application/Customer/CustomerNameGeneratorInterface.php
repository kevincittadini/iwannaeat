<?php

namespace IWannaEat\Application\Customer;

use IWannaEat\Domain\Customer\CustomerName;

interface CustomerNameGeneratorInterface
{
    public function generate(): CustomerName;
}
