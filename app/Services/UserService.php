<?php

namespace App\Services;

use App\User;

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
            'password' => bcrypt($request->get('password')),
            'token' => str_random(20),
        ]);
    }


    /**
     * Update User model
     *
     * @param $user
     * @param $updField
     * @param $updValue
     * @return bool
     */
    public function updateUser($user, $updField, $updValue): bool
    {
        return $user->update([$updField => $updValue]);
    }
}
