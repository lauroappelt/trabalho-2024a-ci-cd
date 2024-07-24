<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Service;

use App\Repository\UserRepository;
use App\Service\UserService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $service;

    private MockObject|UserRepository $mockRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = $this->createMock(UserRepository::class);

        $this->service = new UserService(
            $this->mockRepository
        );
    }

    public function testShouldCreateUser(): void
    {
        $userData = [
            'name' => 'joaozinho',
            'email' => 'joaozinho@mail.com'
        ];

        $this->mockRepository->expects($this->once())
            ->method('create')
            ->willReturn($userData);

        $user = $this->service->createUser($userData);

        self::assertSame($user, $userData);
    }
}
