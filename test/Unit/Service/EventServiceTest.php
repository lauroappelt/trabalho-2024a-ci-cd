<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Service;

use App\Repository\EventRepository;
use App\Service\EventService;
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
                ],
            ]);

        $events = $this->service->listAll();

        $event = current($events);

        self::assertIsArray($events);
        self::assertArrayHasKey('id', $event);
        self::assertArrayHasKey('title', $event);
        self::assertArrayHasKey('description', $event);
        self::assertArrayHasKey('date', $event);
    }

    public function testShouldShowEventWithUsers(): void
    {
        $this->mockRepository->expects($this->once())
            ->method('find')
            ->willReturn(
                json_decode(file_get_contents(BASE_PATH . '/test/utils/payloads/evento.json'), true)
            );

        $eventWithUsers = $this->service->showUsersOfEvent(1);

        self::assertIsArray($eventWithUsers);
        self::arrayHasKey('id', $eventWithUsers);
        self::arrayHasKey('title', $eventWithUsers);
        self::arrayHasKey('description', $eventWithUsers);
        
        self::arrayHasKey('subscriptions', $eventWithUsers);
        self::assertIsArray($eventWithUsers['subscriptions']);
    }
}
