<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Controller;

use App\Controller\SubscriptionController;
use App\Service\SubscriptionService;
use Hyperf\Context\ApplicationContext;
use Hyperf\HttpMessage\Server\Response as ServerResponse;
use Hyperf\HttpServer\Request;
use Hyperf\HttpServer\Response;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class SubscriptionControllerTest extends TestCase
{
    private SubscriptionController $controller;

    private $requestMock;

    private $responseMock;

    private MockObject|SubscriptionService $mockService;

    public function setUp(): void
    {
        parent::setUp();

        $container = ApplicationContext::getContainer();

        $responseMock = $container->make(
            Response::class,
            [$container->make(ServerResponse::class)]
        );

        $requestMock = $this->createMock(Request::class);

        $this->responseMock = $responseMock;

        $this->requestMock = $requestMock;

        $this->mockService = $this->createMock(SubscriptionService::class);

        $this->controller = new SubscriptionController(
            $this->mockService,
            $this->createMock(ValidatorFactoryInterface::class)
        );
    }

    public function testShouldGetSubscription(): void
    {   
        $subscription = [
            'id' => 1,
            'user_id' => 1,
            'event_id' => 1
        ];

        $this->mockService->expects($this->once())
            ->method('showSubscription')
            ->willReturn($subscription);

        $response = $this->controller->showSubscription(1, $this->requestMock, $this->responseMock);

        self::assertSame($subscription, json_decode($response->getBody()->getContents(), true));
    }

    public function testSubscriptionNotExists(): void
    {   
        $this->mockService->expects($this->once())
            ->method('showSubscription')
            ->willReturn([]);

        $response = $this->controller->showSubscription(1, $this->requestMock, $this->responseMock);

        self::assertSame(404, $response->getStatusCode());
    }

    public function testDeleteSubscription(): void
    {   
        $this->mockService->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $response = $this->controller->delete(1, $this->requestMock, $this->responseMock);

        self::assertSame(200, $response->getStatusCode());
    }

    public function testCouldNotDeleteSubscription(): void
    {   
        $this->mockService->expects($this->once())
            ->method('delete')
            ->willReturn(false);

        $response = $this->controller->delete(1, $this->requestMock, $this->responseMock);

        self::assertSame(400, $response->getStatusCode());
    }
}
