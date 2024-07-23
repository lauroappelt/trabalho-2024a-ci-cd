<?php

declare(strict_types=1);

namespace App\Repository;

use Hyperf\DbConnection\Db;

class SubscriptionRepository
{
    public function __construct(
        private Db $db
    ) {
    }

    public function create(array $subscriptionData): array
    {
        $subscriptionId = $this->db
            ->table('subscriptions')
            ->insertGetId($subscriptionData);

        return (array) $this->db->table('subscriptions')
            ->where('id', '=', $subscriptionId)
            ->get()
            ->first();
    }

    public function find(int $subscriptionId): ?array
    {
        return (array) $this->db->table('subscriptions')
            ->where('id', '=', $subscriptionId)
            ->get()
            ->first();
    }

    public function delete(int $subscriptionId): bool
    {
        return $this->db->table('subscriptions')->delete($subscriptionId);
    }
}
