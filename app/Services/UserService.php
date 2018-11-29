<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\ResetPassword;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
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
     * @param $value
     * @return User|bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function one($value)
    {
        if ($user = User::query()->where('name', $value)->first()) {
            return $user;
        }
        return false;
    }


    /**
     * Create User model
     *
     * @param $request
     * @return User
     */
    public function createUser($data): bool
    {
        $password = array_get($data,'password');

        $user = User::query()->make()->fill(
            array_merge(
                array_only($data,['name','email']),
                [
                    'password'=>sha1($password),
                ]
            )
        );

        if ($user){
            return $user->save();
        }

        return false;


//        return User::query()->create([
//            'name' => $request->get('name'),
//            'email' => $request->get('email'),
//            'password' => Hash::make($request->get('password')),
//            'token' => password_hash(str_random(10), PASSWORD_BCRYPT),
//        ]);
    }


    /**
     * Update User model
     *
     * @param $email
     * @param $token
     * @return bool
     */
    public function resetPwd($email, $token): ResetPassword
    {
        return ResetPassword::create([
            'email' => $email,
            'token' => $token
        ]);
    }

}
