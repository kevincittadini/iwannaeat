<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Customer;

use IWannaEat\Domain\EmailAddress;
use IWannaEat\Domain\Id;
use IWannaEat\Domain\SimpleEntity;

/**
 * @psalm-type CustomerData = array{id: string, name: CustomerNameData, emailAddress: string}
 * @psalm-import-type CustomerNameData from CustomerName
 */
final class Customer implements SimpleEntity
{
    public function __construct(
        public readonly Id $id,
        public readonly CustomerName $name,
        public readonly EmailAddress $emailAddress
    ) {
    }

    public function getId(): string
    {
        return (string) $this->id;
    }

    public static function deserialize(array $data): self
    {
        /** @psalm-var CustomerData $data */
        return new self(
            new Id($data['id']),
            CustomerName::deserialize($data['name']),
            new EmailAddress($data['emailAddress'])
        );
    }

    /**
     * @psalm-return CustomerData $data
     */
    public function serialize(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name->serialize(),
            'emailAddress' => $this->emailAddress->toString(),
        ];
    }
}
