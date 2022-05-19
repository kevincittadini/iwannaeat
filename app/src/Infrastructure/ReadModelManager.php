<?php

declare(strict_types=1);

namespace IWannaEat\Infrastructure;

use MongoDB\Client;

final class ReadModelManager
{
    public function __construct(
        private string $dbName,
        private Client $client
    ) {
    }

    public function init(): void
    {
        $this->client->dropDatabase($this->dbName);
    }
}
