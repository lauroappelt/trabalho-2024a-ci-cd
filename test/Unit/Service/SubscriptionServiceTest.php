<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Service;

use App\Repository\SubscriptionRepository;
use App\Service\SubscriptionService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Service\Attribute\SubscribedService;

class SubscriptionServiceTest extends TestCase
{
    private SubscriptionService $service;

    private MockObject|SubscriptionRepository $mockRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockRepository = $this->createMock(SubscriptionRepository::class);

        $this->service = new SubscriptionService(
            $this->mockRepository
        );
    }

    public function testShouldCreateSubscription(): void
    {
        $subscritionData = [
            'user_id' => 1,
            'event_id' => 1
        ];

        $this->mockRepository->expects($this->once())
            ->method('create')
            ->willReturn($subscritionData);

        $subscription = $this->service->createSubscription($subscritionData);

        self::assertSame($subscritionData, $subscription);
    }

    public function testShouldReturnSubscriptionById(): void
    {
        $subscriptionData = $subscritionData = [
            'user_id' => 1,
            'event_id' => 1
        ];

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->willReturn($subscriptionData);

        $subscription = $this->service->showSubscription(1);

        self::assertSame($subscription, $subscriptionData);
    }

    public function testShouldReturnEmptyIfSubscriptionNotExists(): void
    {
        $this->mockRepository->expects($this->once())
            ->method('find')
            ->willReturn([]);

        $subscription = $this->service->showSubscription(1);

        self::assertEmpty($subscription);
        self::assertIsArray($subscription);
    }

    public function testShouldDeleteSubscription(): void
    {
        $this->mockRepository->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $deleted = $this->service->delete(1);

        self::assertTrue($deleted);
    }
}
