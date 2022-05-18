<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Application\ApiController;

use Assert\Assertion;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

final class OrderControllerTest extends ApiTestCase
{
    /** @test */
    public function it_places_order_via_api_and_returns_order_id(): void
    {
        $response = $this->http->post('/orders', []);
        $this->assertIsValidPlaceOrderResponse($response);
    }

    /** @test */
    public function it_can_retrieve_order_recap_after_placing(): void
    {
        $orderPlaceResponse = $this->http->post('/orders', []);
        $order = $this->responseBodyToArray($orderPlaceResponse);

        $orderRecapResponse = $this->http->get(sprintf('/orders/%s', $order['orderId']), []);

        $this->assertIsValidOrderRecapResponse($orderRecapResponse);
    }

    private function assertIsValidPlaceOrderResponse(ResponseInterface $response): void
    {
        $actual = $this->responseBodyToArray($response);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertTrue(isset($actual['orderId']));
        $this->assertTrue(Assertion::uuid($actual['orderId']));
    }

    private function assertIsValidOrderRecapResponse(ResponseInterface $response): void
    {

    }
}
