<?php

namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\select;

class UserRepository implements UserRepositoryInterface
{
    private string $table;
    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function create(string $name, string $email, string $password, string $status) {
        try{
            return DB::table($this->table)->insertGetId([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => $status
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }

    public function update(int $id, ?string $name, ?string $email, ?string $status)
    {
        if ($name === null and $email === null and $status === null) {
            return 0;
        }

        $updates = [];
        if($name !== null) {
            $updates = array_merge($updates, ['name' => $name]);
        }

        if($email !== null) {
            $updates = array_merge($updates, ['email' => $email]);
        }

        if($status !== null) {
            $updates = array_merge($updates, ['status' => $status]);
        }

        if(count($updates) === 0) {
            return 0;
        }

        return DB::table($this->table)->where('id', $id)->update($updates);
    }

    public function get(int $id)
    {
        return DB::table($this->table)->select(["id", "name", "email"])->where('id', $id)->first();
    }

    public function getAll()
    {
        return DB::table($this->table)->select(["id", "name", "email"])->get();
    }
}
