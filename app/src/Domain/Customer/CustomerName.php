<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Customer;

use Broadway\Serializer\Serializable;

/**
 * @psalm-type CustomerNameData = array{familyName: string, names: string[]}
 */
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
        /** @psalm-var CustomerNameData $data */
        return new self(
            $data['familyName'],
            $data['names']
        );
    }

    /** @psalm-return CustomerNameData */
    public function serialize(): array
    {
        return [
           'familyName' => $this->familyName,
           'names' => $this->names,
       ];
    }
}
