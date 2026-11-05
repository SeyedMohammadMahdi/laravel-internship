<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    public function __construct() {
        $this->userRepository = app(UserRepositoryInterface::class);
    }
    public function create(string $name, string $email, string $password) {
        $createdUser = $this->userRepository->create(name: $name, email: $email, password: $password, status: "active");
        if (is_int($createdUser)) {
            return [
                "message" => "User created successfully.",
                "status_code" => 201,
            ];
        }
        return [
            "message" => "User creation Failed.",
            "status_code" => 500,
        ];
    }

}
