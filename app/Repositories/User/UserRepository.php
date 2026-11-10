<?php

namespace App\Repositories\User;

use App\DTOs\UserDataDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use function Laravel\Prompts\select;

class UserRepository implements UserRepositoryInterface
{
    private string $table;
    public function __construct(string $table)
    {
        $this->table = $table;
    }
    public function create(UserDataDTO $user): int|false
    {
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status,
            'password' => Hash::make($user->password),
            'updated_at' => now(),
            'created_at' => now(),
        ];


        try {
            return DB::table($this->table)->insertGetId($userData);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }

    public function update(UserDataDTO $user): int
    {
        $userData = $user->toArray();
        $userData['updated_at'] = now();
        return DB::table($this->table)->where('id', $user->id)->update($userData);
    }

    public function get(int $id)
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function getAll()
    {
        return DB::table($this->table)->select(["id","name", "email","status"])->get();
//        return DB::table($this->table)->select(["id", "name", "email"])->get();
    }

    public function delete(int $id) {
        return DB::table($this->table)->where('id', $id)->delete();
    }
}
