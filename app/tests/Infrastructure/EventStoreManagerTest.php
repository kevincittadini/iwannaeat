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

    private $connection;
    private $eventStore;
    private $schemaManager;
    private $table;
    private string $tableName;

    public function setUp(): void
    {
        $this->connection = $this->prophesize(Connection::class);
        $this->eventStore = $this->prophesize(DBALEventStore::class);
        $this->schemaManager = $this->prophesize(AbstractSchemaManager::class);
        $this->table = $this->prophesize(Table::class);
        $this->tableName = 'events';
        $this->table->getName()->shouldBeCalled()->willReturn($this->tableName);
    }

    /** @test */
    public function it_creates_event_store_if_table_not_exists(): void
    {
        $this->connection->createSchemaManager()->shouldBeCalled()->willReturn($this->schemaManager);
        $this->eventStore->configureTable()->shouldBeCalled()->willReturn($this->table);
        $this->schemaManager->tablesExist($this->tableName)->shouldBeCalled()->willReturn(false);
        $this->schemaManager->dropTable($this->tableName)->shouldNotBeCalled();
        $this->schemaManager->createTable($this->table)->shouldBeCalled();

        (new EventStoreManager($this->connection->reveal(), $this->eventStore->reveal()))->init();
    }

    /** @test */
    public function it_drops_and_creates_event_store_if_table_exists(): void
    {
        $this->connection->createSchemaManager()->shouldBeCalled()->willReturn($this->schemaManager);
        $this->eventStore->configureTable()->shouldBeCalled()->willReturn($this->table);
        $this->schemaManager->tablesExist($this->tableName)->shouldBeCalled()->willReturn(true);
        $this->schemaManager->dropTable($this->tableName)->shouldBeCalled();
        $this->schemaManager->createTable($this->table)->shouldBeCalled();

        (new EventStoreManager($this->connection->reveal(), $this->eventStore->reveal()))->init();
    }
}
