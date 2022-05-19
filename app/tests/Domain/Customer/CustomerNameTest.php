<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Customer;

use IWannaEat\Domain\Customer\CustomerName;
use PHPUnit\Framework\TestCase;

class CustomerNameTest extends TestCase
{
    /** @test */
    public function it_shows_customer_full_name(): void
    {
        $familyName = 'Rossi';
        $names = 'Alessandro';
        $customerName = new CustomerName($familyName, $names);
        $this->assertSame('Alessandro ROSSI', $customerName->getFullName());
    }

    /** @test */
    public function it_shows_customers_full_name_with_multiple_names(): void
    {
        $familyName = 'Rossi';
        $names = ['Alessandro', 'Mario'];
        $customerName = new CustomerName($familyName, $names);
        $this->assertSame('Alessandro Mario ROSSI', $customerName->getFullName());
    }
}
