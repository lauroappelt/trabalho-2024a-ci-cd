<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Controller\AttendanceController;
use App\Controller\EventController;
use App\Controller\SubscriptionController;
use App\Controller\UserController;
use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');

Router::get('/favicon.ico', function () {
    return '';
});


Router::post('/usuarios', [UserController::class, 'createUser']);

Router::get('/eventos', [EventController::class, 'index']);
Router::get('/eventos/{id}', [EventController::class, 'showUsers']);

Router::post('/inscricoes', [SubscriptionController::class, 'createSubscription']);
Router::get('/inscricoes/{id}', [SubscriptionController::class, 'showSubscription']);
Router::delete('/inscricoes/{id}', [SubscriptionController::class, 'delete']);

Router::post('/presencas', [AttendanceController::class, 'createAttendance']);