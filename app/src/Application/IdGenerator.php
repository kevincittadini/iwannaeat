<?php

declare(strict_types=1);

namespace IWannaEat\Application;

use IWannaEat\Domain\Id;
use Ramsey\Uuid\Uuid;

final class IdGenerator implements IdGeneratorInterface
{
    public function generate(): Id
    {
        return new Id(Uuid::uuid4()->toString());
    }
}
