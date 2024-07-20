<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Service;

use App\Repository\AttendanceRepository;
use App\Service\AttendanceService;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class AttendanceServiceTest extends TestCase
{
    private AttendanceService $service;

    private MockInterface|AttendanceRepository $mockRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = $this->createMock(AttendanceRepository::class);

        $this->service = new AttendanceService(
            $this->mockRepository
        );
    }

    public function testShouldCreateAttendance(): void
    {
        $data = [
            'subscription_id' => 1
        ];

        $return = [
            'id' => 1,
            'subscription_id' => 1
        ];

        $this->mockRepository->expects($this->once())
            ->method('create')
            ->willReturn($return);

        $attendance = $this->service->createAttendance($data);

        self::assertIsArray($attendance);
        self::assertSame($return, $attendance);
    }
}
