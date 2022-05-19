<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Domain\Customer;

use IWannaEat\Domain\Customer\Customer;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Application\IdGenerator;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    private Id $id;
    private CustomerName $customerName;
    private EmailAddress $email;
    private Customer $customer;

    protected function setUp(): void
    {
        $this->id = (new IdGenerator())->generate();
        $this->customerName = new CustomerName('Rossi', 'Paolo');
        $this->email = new EmailAddress('info@test.com');

        $this->customer = new Customer(
            $this->id,
            $this->customerName,
            $this->email
        );
    }

    /** @test */
    public function it_holds_customers_data(): void
    {
        $this->assertEquals($this->id, $this->customer->id);
        $this->assertEquals($this->customerName, $this->customer->name);
        $this->assertEquals($this->email, $this->customer->emailAddress);
    }

    /** @test */
    public function it_serializes_data(): void
    {
        $this->assertEquals([
            'id' => (string)$this->id,
            'name' => $this->customerName->serialize(),
            'emailAddress' => $this->email->toString(),
        ], $this->customer->serialize());
    }

    /** @test */
    public function it_deserializes(): void
    {
        $expected = $this->customer;
        $actual = Customer::deserialize([
            'id' => (string)$this->id,
            'name' => $this->customerName->serialize(),
            'emailAddress' => $this->email->toString(),
        ]);

        $this->assertEquals($expected, $actual);
    }
}
