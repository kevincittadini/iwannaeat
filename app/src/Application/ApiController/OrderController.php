<?php

declare(strict_types=1);

namespace IWannaEat\Application\ApiController;

use Broadway\CommandHandling\CommandBus;
use Broadway\ReadModel\Repository;
use IWannaEat\Application\Customer\CustomerGenerator;
use IWannaEat\Application\IdGenerator;
use IWannaEat\Application\Order\OrderRecapModel;
use IWannaEat\Application\Product\ProductListGenerator;
use IWannaEat\Domain\Order\PlaceOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OrderController
{
    public function __construct(
        private IdGenerator $idGenerator,
        private CommandBus $commandBus,
        private Repository $orderRecapRepository,
        private CustomerGenerator $customerGenerator,
        private ProductListGenerator $productListGenerator
    ) {
    }

    #[Route('/orders', name: 'place_order_action', methods: ['POST'])]
    public function placeOrderAction(): JsonResponse
    {
        $orderId = $this->idGenerator->generate();
        $customer = $this->customerGenerator->generate();
        $productList = $this->productListGenerator->generate();

        try {
            $this->commandBus->dispatch(
                new PlaceOrder(
                    $orderId,
                    $customer,
                    $productList,
                    new \DateTimeImmutable()
                )
            );

            return new JsonResponse(['orderId' => (string) $orderId], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/orders/{orderId}', name: 'get_order_recap_action', methods: ['GET'])]
    public function getOrderRecapAction(string $orderId): JsonResponse
    {
        try {
            /** @var OrderRecapModel|null $orderRecap */
            $orderRecap = $this->orderRecapRepository->find($orderId);

            if (is_null($orderRecap)) {
                throw new \DomainException('Order not found.');
            }

            return new JsonResponse($orderRecap->serialize(), Response::HTTP_OK);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
