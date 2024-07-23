<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Controller;

use App\Controller\UserController;
use App\Service\UserService;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ValidatorInterface;
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
class UserControllerTest extends TestCase
{
    private UserController $controller;

    private MockObject|UserService $mockUserService;

    private MockObject|ValidatorFactoryInterface $mockValidator;

    public function setUp(): void
    {
        $this->mockUserService = $this->createMock(UserService::class);

        $this->mockValidator = $this->createMock(ValidatorFactoryInterface::class);

        $this->controller = new UserController(
            $this->mockValidator,
            $this->mockUserService
        );
    }

    public function testShouldCreateUser(): void
    {
        $container = ApplicationContext::getContainer();

        $responseMock = $container->make(
            Response::class,
            [$container->make(ServerResponse::class)]
        );

        $userData = [
            'name' => 'joao',
            'email' => 'joao@mail.com',
        ];

        $requestMock = $this->createMock(Request::class);

        $requestMock->method('all')
            ->willReturn($userData);

        $this->mockUserService->method('createUser')
            ->willReturn($userData);

        $response = $this->controller->createUser($requestMock, $responseMock);

        self::assertSame($userData, json_decode($response->getBody()->getContents(), true));
        self::assertEquals(201, $response->getStatusCode());
    }

    public function testShouldNotCreateUser(): void
    {
        $container = ApplicationContext::getContainer();

        $responseMock = $container->make(
            Response::class,
            [$container->make(ServerResponse::class)]
        );

        $requestMock = $this->createMock(Request::class);

        $requestMock->method('all')
            ->willReturn([]);

        $validator = $this->createMock(ValidatorInterface::class);

        $validator->method('fails')
            ->willReturn(true);

        $this->mockValidator->method('make')
            ->willReturn($validator);

        $response = $this->controller->createUser($requestMock, $responseMock);

        self::assertEquals(422, $response->getStatusCode());
    }
}
