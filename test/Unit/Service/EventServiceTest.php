<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Service;

use App\Repository\EventRepository;
use App\Service\EventService;
use Mockery\Mock;
use Mockery\MockInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class EventServiceTest extends TestCase
{
    private EventService $service;

    private EventRepository|MockObject $mockRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = $this->createMock(EventRepository::class);

        $this->service = new EventService(
            $this->mockRepository
        );
    }

    public function testShouldListAllEvents(): void
    {
        $this->mockRepository->expects($this->once())
            ->method('all')
            ->willReturn([
                [
                    'id' => 1,
                    'title' => 'ifwhefwqifegwf',
                    'description' => 'ishjbdakbdksad',
                    'date' => date('Y-m-d'),
                ]

            ]);

        $events = $this->service->listAll();

        $event = current($events);

        self::assertIsArray($events);
        self::assertArrayHasKey('id', $event);
        self::assertArrayHasKey('title', $event);
        self::assertArrayHasKey('description', $event);
        self::assertArrayHasKey('date', $event);
    }

    public function testShouldShowUsers(): void
    {
        $this->mockRepository->expects($this->once())
            ->method('find')
            ->willReturn([]);

        $users = $this->service->showUsers(1);

        self::assertIsArray($users);
    }
}
