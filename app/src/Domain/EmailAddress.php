<?php

declare(strict_types=1);

namespace IWannaEat\Domain;

final class EmailAddress
{
    public function __construct(
        public readonly string $emailAddress
    ) {
        if (!filter_var($this->emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new \DomainException('Invalid email address.');
        }
    }

    public function toString(): string
    {
        return $this->emailAddress;
    }
}
