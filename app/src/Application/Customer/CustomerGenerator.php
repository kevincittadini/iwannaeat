<?php

declare(strict_types=1);

namespace IWannaEat\Application\Customer;

use IWannaEat\Application\EmailAddressGeneratorInterface;
use IWannaEat\Application\IdGeneratorInterface;
use IWannaEat\Domain\Customer\Customer;

final class CustomerGenerator
{
    public function __construct(
        private IdGeneratorInterface $idGenerator,
        private CustomerNameGeneratorInterface $customerNameGenerator,
        private EmailAddressGeneratorInterface $emailAddressGenerator
    ) {
    }

    public function generate(): Customer
    {
        return new Customer(
            $this->idGenerator->generate(),
            $this->customerNameGenerator->generate(),
            $this->emailAddressGenerator->generate()
        );
    }
}
