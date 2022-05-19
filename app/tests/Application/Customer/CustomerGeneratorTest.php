<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Application\Customer;

use IWannaEat\Application\Customer\CustomerGenerator;
use IWannaEat\Application\Customer\CustomerNameGeneratorInterface;
use IWannaEat\Application\EmailAddressGeneratorInterface;
use IWannaEat\Application\IdGeneratorInterface;
use IWannaEat\Domain\Customer\CustomerName;
use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Ramsey\Uuid\Uuid;

class CustomerGeneratorTest extends TestCase
{
    use ProphecyTrait;

    private CustomerGenerator $customerGenerator;
    private $idGenerator;
    private $customerNameGenerator;
    private $emailAddressGenerator;

    protected function setUp(): void
    {
        $this->idGenerator = $this->prophesize(IdGeneratorInterface::class);
        $this->customerNameGenerator = $this->prophesize(CustomerNameGeneratorInterface::class);
        $this->emailAddressGenerator = $this->prophesize(EmailAddressGeneratorInterface::class);

        $this->customerGenerator = new CustomerGenerator(
            $this->idGenerator->reveal(),
            $this->customerNameGenerator->reveal(),
            $this->emailAddressGenerator->reveal()
        );
    }

    /** @test */
    public function it_generates_a_customer(): void
    {
        $this->idGenerator->generate()
            ->shouldBeCalledTimes(1)
            ->willReturn(new Id(Uuid::uuid4()->toString()));

        $this->customerNameGenerator->generate()
            ->shouldBeCalledTimes(1)
            ->willReturn(new CustomerName('Rossi', ['Mario']));

        $this->emailAddressGenerator->generate()
            ->shouldBeCalledTimes(1)
            ->willReturn(new EmailAddress('info@example.com'));

        $this->customerGenerator->generate();
    }
}
