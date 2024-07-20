<?php

declare(strict_types=1);

namespace App\Repository;

use Hyperf\DbConnection\Db;

class AttendanceRepository
{
    public function __construct(
        private Db $db
    ) {
    }

    public function create(array $data): array
    {
        $attendanceId = $this->db
            ->table('attendances')
            ->insertGetId($data);

        return (array) $this->db->table('attendances')
            ->where('id', '=', $attendanceId)
            ->get()
            ->first();
    }
}
