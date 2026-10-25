<?php
namespace App\Services;

use Illuminate\Http\Request;

class UserList {
    public function ListUsers(): array {
        return [
            ["name" => "mohammad", "age" => 20],
            ["name" => "madhi", "age" => 26],
            ["name" => "reza", "age" => 25],
        ];
    }
}
