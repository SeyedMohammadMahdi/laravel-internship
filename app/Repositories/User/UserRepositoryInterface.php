<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function create(string $name, string $email, string $password, string $status);
}
