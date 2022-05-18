<?php

declare(strict_types=1);

namespace IWannaEat\Application\ApiController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class OrderController
{
    #[Route('/orders', name: 'place_order_action', methods: ['POST'])]
    public function placeOrderAction(): JsonResponse
    {
        return new JsonResponse([]);
    }
}
