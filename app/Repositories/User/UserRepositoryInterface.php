<?php

namespace App\Repositories\User;

use App\DTOs\UserDataDTO;

interface UserRepositoryInterface
{
//    public function create(string $name, string $email, string $password, string $status);
    public function create(UserDataDTO $user): int|false;
//    public function update(int $id, ?string $name, ?string $email, ?string $status);
    public function update(UserDataDTO $user): int;
    public function get(int $id);

    public function getAll();
}
