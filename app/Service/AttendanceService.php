<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\AttendanceRepository;

class AttendanceService
{
    public function __construct(
        private AttendanceRepository $attendanceRepository,
    ) {
    }

    public function createAttendance(array $data): array
    {
        return $this->attendanceRepository->create($data);
    }
}
