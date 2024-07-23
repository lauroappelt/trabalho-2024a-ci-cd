<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\SubscriptionRepository;

class SubscriptionService
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository
    ) {
    }

    public function createSubscription(array $subscriptionData): array
    {
        return $this->subscriptionRepository->create($subscriptionData);
    }

    public function showSubscription(int $subscriptionId): ?array
    {
        return $this->subscriptionRepository->find($subscriptionId);
    }

    public function delete(int $subscriptionId): bool
    {
        return $this->subscriptionRepository->delete($subscriptionId);
    }
}
