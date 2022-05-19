<?php

declare(strict_types=1);

namespace IWannaEat\Domain\Customer;

use IWannaEat\Domain\SimpleEntity;

final class Customer implements SimpleEntity
{
    public function getId(): string
    {
        // TODO: Implement getId() method.
    }

    public static function deserialize(array $data)
    {
        // TODO: Implement deserialize() method.
    }

    public function serialize(): array
    {
        // TODO: Implement serialize() method.
    }
}
