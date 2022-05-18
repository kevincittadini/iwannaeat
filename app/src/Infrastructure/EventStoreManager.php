<?php

declare(strict_types=1);

namespace IWannaEat\Infrastructure;

use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Connection;

final class EventStoreManager
{
    public function __construct(
        private Connection $connection,
        private DBALEventStore $eventStore
    ) {
    }

    public function init(): void
    {
        $schemaManager = $this->connection->createSchemaManager();
        $table = $this->eventStore->configureTable();

        if ($schemaManager->tablesExist($table->getName())) {
            $schemaManager->dropTable($table->getName());
        }

        $schemaManager->createTable($table);
    }
}
