<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * Get User model collection
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): array
    {
        return User::all(); // other logic
    }


    /**
     * Get User model instance
     *
     * @param $field
     * @param $value
     * @return User
     */
    public function getUser($field, $value): User
    {
        return User::where($field, $value)
            ->first();
    }


    /**
     * Create User model
     *
     * @param $request
     * @return User
     */
    public function createUser($request): User
    {
        return User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'token' => password_hash(str_random(10), PASSWORD_BCRYPT),
        ]);
    }


    /**
     * Update User model
     *
     * @param $user
     * @param $field
     * @param $value
     * @return bool
     */
    public function updateUser($user, $field, $value): bool
    {
        return $user->update([$field => $value]);
    }

}
