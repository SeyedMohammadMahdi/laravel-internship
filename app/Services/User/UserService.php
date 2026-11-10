<?php

namespace App\Services\User;

use App\DTOs\UserDataDTO;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Support\Facades\Hash;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UserService
{
    private UserRepositoryInterface $userRepository;
    public function __construct() {
        $this->userRepository = app(UserRepositoryInterface::class);
    }
//    public function create(string $name, string $email, string $password) {
//        $createdUser = $this->userRepository->create(name: $name, email: $email, password: $password, status: "active");
//        if (is_int($createdUser)) {
//            return [
//                "message" => "User created successfully.",
//                "status_code" => 201,
//            ];
//        }
//        return [
//            "message" => "User creation Failed.",
//            "status_code" => 500,
//        ];
//    }

    public function create(UserDataDTO $user){
        $userToCreate = new UserDataDTO(
            $user->id,
            $user->name,
            $user->email,
            'active',
            $user->password,
        );
        $createdUser = $this->userRepository->create($userToCreate);
        if (is_int($createdUser)) {
            return [
                "success" => true,
                "message" => "user created",
                "status_code" => 201
            ];
        }
        return [
            "success" => false,
            "message" => "user not created",
            "status_code" => 400
        ];
    }
    public function update(UserDataDTO $user): array {
        $dbUser = $this->userRepository->get($user->id);
        $userTOUpdate = new UserDataDTO(
            $user->id,
            $user->name ?? $dbUser->name,
            $user->email ?? $dbUser->email,
            $user->password !== null ? Hash::make($user->password):$dbUser->password,
        );
        $updated = $this->userRepository->update($userTOUpdate);
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

//    /**
//     * @throws CircularDependencyException
//     * @throws EntryNotFoundException
//     * @throws NotFoundExceptionInterface
//     * @throws ContainerExceptionInterface
//     */
    public function get(?int $id=null): array {
        if(is_null($id)) {
            $users = $this->userRepository->getAll();
            if ($users->count() === 0) {
                return [
                    "message" => "No users found.",
                    "status_code" => 404,
                ];
            }
            return [
                "message" => "User found.",
                "status_code" => 200,
                "data" => $users->toArray(),
            ];
        }
        $user = $this->userRepository->get($id);
        if (is_null($user)) {
            return [
                "message" => "User not found.",
                "status_code" => 404,
            ];
        }
        return [
            "message" => "User retrieved successfully.",
            "status_code" => 200,
            "data" => $user,
        ];
    }
    public function delete(int $id) {
        $deleted = $this->userRepository->delete($id);
        if ($deleted > 0) {
            return [
                "message" => "User deleted successfully.",
                "status_code" => 200,
            ];
        }
        return [
            "message" => "User is not deleted.",
            "status_code" => 400,
        ];
    }
}
