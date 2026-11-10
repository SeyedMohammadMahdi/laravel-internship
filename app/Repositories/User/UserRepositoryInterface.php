<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function create(string $name, string $email, string $password, string $status);
    public function update(int $id, ?string $name, ?string $email, ?string $status);
    public function get(int $id);

    public function getAll();
}
