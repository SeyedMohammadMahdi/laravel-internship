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
        $output = [];
        if (!is_null($this->id)) {
            $output['id'] = $this->id;
        }
        if (!is_null($this->name)) {
            $output['name'] = $this->name;
        }
        if (!is_null($this->email)) {
            $output['email'] = $this->email;
        }
        if (!is_null($this->status)) {
            $output['status'] = $this->status;
        }
        if (!is_null($this->password)) {
            $output['password'] = $this->password;
        }
        return $output;
    }
}
