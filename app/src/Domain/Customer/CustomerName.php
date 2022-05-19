<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Customer;

use Broadway\Serializer\Serializable;

final class CustomerName implements Serializable
{
    /** @var string[] */
    private array $names;
    private string $familyName;

    /** @param string|string[] $names */
    public function __construct(
        string $familyName,
        string|array $names
    ) {
        if (is_string($names)) {
            $names = [$names];
        }

        $this->names = $names;
        $this->familyName = $familyName;
    }

    public function getFullName(): string
    {
        return sprintf(
            '%s %s',
            implode(' ', $this->names), mb_strtoupper($this->familyName)
        );
    }

    public static function deserialize(array $data): self
    {
        return new self(
            $data['familyName'],
            $data['names']
        );
    }

    public function serialize(): array
    {
       return [
           'familyName' => $this->familyName,
           'names' => $this->names,
       ];
    }
}
