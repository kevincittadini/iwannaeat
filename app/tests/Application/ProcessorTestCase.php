<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application;

use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\Processor\Processor;
use Broadway\Serializer\Serializable;
use Composer\XdebugHandler\Process;
use PHPUnit\Framework\TestCase;

abstract class ProcessorTestCase extends TestCase
{
    protected function eventToDomainMessage(Serializable $event): DomainMessage
    {
        return DomainMessage::recordNow(
            '1',
            1,
            new Metadata(),
            $event
        );
    }

    protected function handleEvent(Serializable $event): void
    {
        $processor = $this->registerProcessor();
        $domainMessage = $this->eventToDomainMessage($event);
        $processor->handle($domainMessage);
    }

    abstract protected function registerProcessor(): Processor;
}
