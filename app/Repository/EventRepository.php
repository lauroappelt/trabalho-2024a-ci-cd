<?php
namespace App\Repository;

use Hyperf\DbConnection\Db;
use Hyperf\Di\Exception\NotFoundException;

class EventRepository
{
    public function __construct(
        private Db $Db
    )
    {
        
    }

    public function all(): array
    {
        return $this->Db->table('events')
            ->get()
            ->toArray();
    }

    public function find(int $eventId): ?array
    {
        $event = (array) $this->Db->table('events')
            ->where('id', '=', $eventId)
            ->get()
            ->first();

        if (empty($event)) {
            return null;
        }

        $users = $this->Db->table('events')
            ->join('subscriptions', 'subscriptions.event_id', '=', 'events.id')
            ->join('users', 'users.id', '=', 'subscriptions.user_id')
            ->where('events.id', '=', $eventId)
            ->get()
            ->all();

        $event['subscriptions'] = $users;

        return $event;
    }
}