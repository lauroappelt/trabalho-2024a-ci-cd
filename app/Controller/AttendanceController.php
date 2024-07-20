<?php

namespace App\Controller;

use App\Service\AttendanceService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class AttendanceController
{
    public function __construct(
        private AttendanceService $attendanceService,
        private ValidatorFactoryInterface $validatorFactory
    ) {

    }

    public function createAttendance(RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $validator = $this->validatorFactory->make(
            $requestInterface->all(),
            [
                'subscription_id' => 'required|integer|exists:subscriptions,id|unique:attendances,subscription_id',
            ],
        );

        if ($validator->fails()) {
            return $responseInterface->json($validator->errors())->withStatus(422);
        }

        $attendance = $this->attendanceService->createAttendance($requestInterface->all());

        return $responseInterface->json($attendance)->withStatus(201);
    }
}
