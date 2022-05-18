<?php

declare(strict_types=1);

namespace IWannaEat\Tests\Application\ApiController;

use GuzzleHttp\Client;
use IWannaEat\Infrastructure\EventStoreManager;
use IWannaEat\Infrastructure\ReadModelManager;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class ApiTestCase extends KernelTestCase
{
    protected Client $http;

    protected function setUp(): void
    {
        $container = (self::bootKernel())->getContainer();

        $this->http = new Client([
            'base_uri' => $container->getParameter('api_base_uri'),
            'allow_redirects' => false,
        ]);

        /** @var EventStoreManager $eventStoreManager */
        $eventStoreManager = $container->get(EventStoreManager::class);
        $eventStoreManager->init();

        /** @var ReadModelManager $readModelManager */
        $readModelManager = $container->get(ReadModelManager::class);
        $readModelManager->init();
    }

    protected function responseBodyToArray(ResponseInterface $response): array
    {
        return \json_decode($response->getBody()->getContents(), true);
    }
}
