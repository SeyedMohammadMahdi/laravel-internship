<?php

namespace App\DTOs;

readonly class UserDataDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $status = null,
        public ?string $password = null,
    )
    {}

    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'password' => $this->password,
        ];
    }
}
