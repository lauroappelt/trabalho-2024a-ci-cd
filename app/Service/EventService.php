<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\EventRepository;

class EventService
{
    public function __construct(
        private EventRepository $eventRepository
    ) {
    }

    public function listAll(): array
    {
        return $this->eventRepository->all();
    }

    public function showUsers(int $eventId): ?array
    {
        return $this->eventRepository->find($eventId);
    }
}
