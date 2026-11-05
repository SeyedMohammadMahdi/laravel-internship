<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    private string $table;
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function create(string $name, string $email, string $password, string $status) {
        return DB::table($this->table)->insertGetId([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'status' => $status
        ]);
    }
}
