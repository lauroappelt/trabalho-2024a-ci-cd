<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\SubscriptionService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Logger\Logger;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class SubscriptionController
{
    private ValidatorFactoryInterface $validatorFactory;

    private Logger $logger;

    public function __construct(
        private SubscriptionService $subscriptionService,
        ValidatorFactoryInterface $validatorFactory,
        LoggerFactory $loggerFactory
    ) {
        $this->validatorFactory = $validatorFactory;

        $this->logger = $loggerFactory->get();
    }

    public function createSubscription(RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $token = $requestInterface->header('api-token');

        if ($token != '71f6ac3385ce284152a64208521c592b') {
            return $responseInterface->json([])->withStatus(401);
        }

        $validator = $this->validatorFactory->make(
            $requestInterface->all(),
            [
                'user_id' => 'required|integer|exists:users,id|unique:subscriptions',
                'event_id' => 'required|integer|exists:events,id',
            ],
        );

        if ($validator->fails()) {
            return $responseInterface->json($validator->errors())->withStatus(422);
        }

        $subscription = $this->subscriptionService->createSubscription($requestInterface->all());

        return $responseInterface->json($subscription)->withStatus(201);
    }

    public function showSubscription($id, RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $token = $requestInterface->header('api-token');

        if ($token != '71f6ac3385ce284152a64208521c592b') {
            return $responseInterface->json([])->withStatus(401);
        }

        $subscription = $this->subscriptionService->showSubscription((int) $id);

        if (empty($subscription)) {
            $this->logger->info('Subscription not foind', ['subscription_id' => $id]);
            return $responseInterface->json([])->withStatus(404);
        }

        return $responseInterface->json($subscription);
    }

    public function delete($id, RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $deleted = $this->subscriptionService->delete((int) $id);

        if (! $deleted) {
            return $responseInterface->json([])->withStatus(400);
        }
    }
}
