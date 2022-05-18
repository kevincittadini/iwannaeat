<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Infrastructure;

use IWannaEat\Infrastructure\ReadModelManager;
use MongoDB\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ReadModelManagerTest extends TestCase
{
    use ProphecyTrait;

    /** @test */
    public function it_inits_read_model_db(): void
    {
        $dbname = 'dbname';

        $client = $this->prophesize(Client::class);
        $client->dropDatabase($dbname)->shouldBeCalled();

        (new ReadModelManager($dbname, $client->reveal()))->init();
    }
}
