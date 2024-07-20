<?php
namespace App\Service;

use App\Repository\AttendanceRepository;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Validator;
use Hyperf\Validation\ValidatorFactory;

class AttendanceService
{
    public function __construct(
        private AttendanceRepository $attendanceRepository,
    )
    {
        
    }

    public function createAttendance(array $data): array
    {
        return $this->attendanceRepository->create($data);
    }
}