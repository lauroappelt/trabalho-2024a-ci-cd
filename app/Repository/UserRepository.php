<?php

namespace App\Repository;

use Hyperf\DbConnection\Db;

class UserRepository
{
    public function __construct(
        private Db $db
    ) {

    }

    public function create(array $userData): array
    {
        $userData['password'] = md5($userData['password']);

        $userId = $this->db->table('users')->insertGetId($userData);

        $user = $this->db->table('users')->where('id', '=', $userId)
            ->get(['id', 'name', 'email', 'cpf'])
            ->first();

        return (array) $user;
    }
}
