<?php

declare(strict_types=1);

namespace IWannaEat\Domain;

use Ramsey\Uuid\Uuid;

final class IdGenerator
{
    public function generate(): Id
    {
        return new Id(Uuid::uuid4()->toString());
    }
}
