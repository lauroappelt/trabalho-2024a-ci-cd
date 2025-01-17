<?php

declare(strict_types=1);
use Hyperf\AsyncQueue\Driver\RedisDriver;

/*
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
return [
    'default' => [
        'driver' => RedisDriver::class,
        'redis' => [
            'pool' => 'default',
        ],
        'channel' => 'jobs',
        'timeout' => 2,
        'retry_seconds' => 5,
        'handle_timeout' => 10,
        'processes' => 1,
        'concurrent' => [
            'limit' => 10,
        ],
    ],
    'emails' => [
        'driver' => RedisDriver::class,
        'redis' => [
            'pool' => 'default',
        ],
        'channel' => 'emails',
        'timeout' => 2,
        'retry_seconds' => 5,
        'handle_timeout' => 10,
        'processes' => 1,
        'concurrent' => [
            'limit' => 1,
        ],
    ],
];
