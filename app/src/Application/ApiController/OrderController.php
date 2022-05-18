<?php

declare(strict_types=1);

namespace IWannaEat\Application\ApiController;

use Broadway\CommandHandling\CommandBus;
use IWannaEat\Domain\IdGenerator;
use IWannaEat\Domain\Order\PlaceOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OrderController
{
    public function __construct(
        private IdGenerator $idGenerator,
        private CommandBus $commandBus
    ) {
    }

    #[Route('/orders', name: 'place_order_action', methods: ['POST'])]
    public function placeOrderAction(): JsonResponse
    {
        $orderId = $this->idGenerator->generate();

        try {
            $this->commandBus->dispatch(
                new PlaceOrder(
                    $orderId,
                    new \DateTimeImmutable()
                )
            );

            return new JsonResponse(['orderId' => (string) $orderId], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], $e->getCode());
        }
    }

    #[Route('/orders/{orderId}', name: 'get_order_recap_action', methods: ['GET'])]
    public function getOrderRecapAction(string $orderId): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }
}
