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
use Hyperf\Logger\Logger;
use Hyperf\Logger\LoggerFactory;

class EventController
{
    private Logger $logger;

    public function __construct(
        private EventService $eventService,
        LoggerFactory $loggerFactory
    ) {
        $this->logger = $loggerFactory->get();
    }

    public function index(RequestInterface $requestInterface, ResponseInterface $responseInterface) {
        $token = $requestInterface->header('api-token');

        if ($token != '71f6ac3385ce284152a64208521c592b') 
        {
            return $responseInterface->json([])->withStatus(401);
        }

        $events = $this->eventService->listAll();

        return $responseInterface->json($events);
    }

    public function showUsers($id, RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $token = $requestInterface->header('api-token');

        if ($token != '71f6ac3385ce284152a64208521c592b') {
            return $responseInterface->json([])->withStatus(401);
        }

        $event = $this->eventService->showUsers((int) $id);

        if (empty($event)) {
            $this->logger->info('Event not found.', ['event_id' => $id]);
            return $responseInterface->json([])->withStatus(404);
        }

        return $responseInterface->json($event);
    }
}
