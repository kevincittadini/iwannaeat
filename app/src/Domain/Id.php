<?php

declare(strict_types=1);

namespace IWannaEat\Domain;

use Assert\Assertion;
use Assert\InvalidArgumentException;

final class Id
{
    public function __construct(
        public readonly string $value
    ) {
        try {
            Assertion::uuid($value);
        } catch (InvalidArgumentException $e) {
            throw new \DomainException('Invalid ID.');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
