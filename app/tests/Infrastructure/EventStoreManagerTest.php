<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Infrastructure;

use Broadway\EventStore\Dbal\DBALEventStore;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Table;
use IWannaEat\Infrastructure\EventStoreManager;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class EventStoreManagerTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function it_inits_event_store(): void
    {
        $connection = $this->prophesize(Connection::class);
        $eventStore = $this->prophesize(DBALEventStore::class);
        $schemaManager = $this->prophesize(AbstractSchemaManager::class);
        $table = $this->prophesize(Table::class);
        $tableName = 'events';
        $table->getName()->shouldBeCalled()->willReturn($tableName);


        $connection->createSchemaManager()->shouldBeCalled()->willReturn($schemaManager);
        $eventStore->configureTable()->shouldBeCalled()->willReturn($table);
        $schemaManager->dropTable($tableName)->shouldBeCalled();
        $schemaManager->createTable($table)->shouldBeCalled();

        (new EventStoreManager($connection->reveal(), $eventStore->reveal()))->init();
    }
}
