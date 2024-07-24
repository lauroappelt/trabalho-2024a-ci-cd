<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Controller;

use App\Controller\EventController;
use App\Service\EventService;
use Hyperf\Context\ApplicationContext;
use Hyperf\HttpMessage\Server\Response as ServerResponse;
use Hyperf\HttpServer\Request;
use Hyperf\HttpServer\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class EventControllerTest extends TestCase
{
    private EventController $controller;

    private EventService|MockObject $mockService;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockService = $this->createMock(EventService::class);

        $this->controller = new EventController(
            $this->mockService
        );
    }

    public function testShouldGetEventsList(): void
    {
        $container = ApplicationContext::getContainer();

        $responseMock = $container->make(
            Response::class,
            [$container->make(ServerResponse::class)]
        );

        $requestMock = $this->createMock(Request::class);

        $events = json_decode(file_get_contents(BASE_PATH . '/test/utils/payloads/eventos.json'), true);

        $this->mockService->expects($this->once())
            ->method('listAll')
            ->willReturn($events);

        $response = $this->controller->index($requestMock, $responseMock);

        self::assertSame($events, json_decode($response->getBody()->getContents(), true));
        self::assertSame(200, $response->getStatusCode());
    }

    public function testShouldShowEventWithUsers(): void
    {
        $container = ApplicationContext::getContainer();

        $responseMock = $container->make(
            Response::class,
            [$container->make(ServerResponse::class)]
        );

        $requestMock = $this->createMock(Request::class);

        $event = json_decode(file_get_contents(BASE_PATH . '/test/utils/payloads/evento.json'), true);

        $this->mockService->expects($this->once())
            ->method('showUsersOfEvent')
            ->willReturn($event);

        $response = $this->controller->showUsers(1, $requestMock, $responseMock);

        self::assertSame($event, json_decode($response->getBody()->getContents(), true));
        self::assertSame(200, $response->getStatusCode());
    }

    public function testEventNotExists(): void
    {
        $container = ApplicationContext::getContainer();

        $responseMock = $container->make(
            Response::class,
            [$container->make(ServerResponse::class)]
        );

        $requestMock = $this->createMock(Request::class);

        $this->mockService->expects($this->once())
            ->method('showUsersOfEvent')
            ->willReturn([]);

        $response = $this->controller->showUsers(1, $requestMock, $responseMock);

        self::assertSame(404, $response->getStatusCode());
    }
}
