<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {

    }

    public function createUser(array $userData): array
    {
        return $this->userRepository->create($userData);
    }
}
