<?php

declare(strict_types=1);

namespace IWannaEat\Domain;

final class Id
{
    public function __construct(
        public readonly string $value
    ) {
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
