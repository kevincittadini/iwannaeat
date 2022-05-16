<?php

declare(strict_types=1);

namespace IWannaEat\Application;

use Ramsey\Uuid\Uuid;

final class IdGenerator
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
