<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Customer;

final class CustomerName
{
    /**
     * @param string $familyName
     * @param string|array<string> $names
     */
    public function __construct(
        private string $familyName,
        private string|array $names
    ) {
    }

    public function getFullName(): string
    {
        if (!is_array($this->names)) {
            $this->names = [$this->names];
        }

        return sprintf(
            '%s %s',
            implode(' ', $this->names), mb_strtoupper($this->familyName)
        );
    }
}
