<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @see     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\Service\EventService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Log\LoggerInterface;

class EventController
{
    private LoggerInterface $logger;

    public function __construct(
        private EventService $eventService,
    ) {
    }

    public function index(RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $token = $requestInterface->header('api-token');

        $events = $this->eventService->listAll();

        return $responseInterface->json($events);
    }

    public function showUsers($id, RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $token = $requestInterface->header('api-token');

        $event = $this->eventService->showUsersOfEvent((int) $id);

        if (empty($event)) {
            return $responseInterface->json([])->withStatus(404);
        }

        return $responseInterface->json($event);
    }
}
