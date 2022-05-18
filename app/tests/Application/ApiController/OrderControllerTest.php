<?php

declare(strict_types=1);


namespace IWannaEat\Tests\Application\ApiController;

final class OrderControllerTest extends ApiTestCase
{
    /** @test */
    public function it_places_order_via_api_and_returns_order_id(): void
    {
        $response = $this->http->post(
            '/orders',
            [
            ]
        );

        $actual = $this->responseBodyToArray($response);

        $this->assertEquals([], $actual);
    }
}
