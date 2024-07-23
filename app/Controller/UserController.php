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

use App\Service\UserService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class UserController
{
    private ValidatorFactoryInterface $validationFactory;

    public function __construct(
        ValidatorFactoryInterface $validatorFactoryInterface,
        private UserService $userService
    ) {
        $this->validationFactory = $validatorFactoryInterface;
    }

    public function createUser(RequestInterface $requestInterface, ResponseInterface $responseInterface)
    {
        $validator = $this->validationFactory->make(
            $requestInterface->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'cpf' => 'required|string|size:11|unique:users,cpf',
                'password' => 'required|string|max:255',
            ],
        );

        if ($validator->fails()) {
            return $responseInterface->json($validator->errors())->withStatus(422);
        }

        $user = $this->userService->createUser($requestInterface->all());

        return $responseInterface->json($user)->withStatus(201);
    }
}
