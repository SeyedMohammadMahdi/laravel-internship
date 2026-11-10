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

    public function update(int $id, ?string $name = null, ?string $email = null, ?string $status = null): array {

        $updated = $this->userRepository->update($id, name: $name, email: $email, status: $status);
        if ($updated > 0) {
            return [
                "message" => "User updated successfully.",
                "status_code" => 200,
            ];
        }
        return [
            "message" => "User update Failed.",
            "status_code" => 500,
        ];
    }

}
