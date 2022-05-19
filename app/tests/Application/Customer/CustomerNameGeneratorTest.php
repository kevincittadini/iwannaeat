<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\Customer;

use IWannaEat\Application\Customer\CustomerNameGenerator;
use PHPUnit\Framework\TestCase;

class CustomerNameGeneratorTest extends TestCase
{
    private CustomerNameGenerator $customerNameGenerator;

    protected function setUp(): void
    {
        $this->customerNameGenerator = new CustomerNameGenerator();
    }

    /** @test */
    public function it_generates_random_names(): void
    {
        $testIterations = 100;
        while ($testIterations > 0) {
            $customerName = $this->customerNameGenerator->generate();

            $data = $customerName->serialize();

            $this->assertIsString($data['familyName']);
            $this->assertIsArray($data['names']);

            foreach ($data['names'] as $name) {
                $this->assertIsString($name);
            }

            $testIterations--;
        }
    }
}
