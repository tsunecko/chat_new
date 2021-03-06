<?php

namespace App\modules\auth\Services;

use App\ResetPassword;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{

    private $user;

    public function __construct()
    {
        $this->user = new User;
    }

    /**
     * Get User model collection
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): array
    {
        return $this->user->all(); // other logic
    }


    /**
     * Get User model instance
     *
     * @param $field
     * @param $value
     * @return User|bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function one($field, $value)
    {
        if ($user = $this->user->query()->where($field, $value)->first()) {
            return $user;
        }
        return false;
    }


    /**
     * Create User model
     *
     * @param $data
     * @return bool
     */
    public function create($data): bool
    {
        $password = array_get($data,'password');

        $user = $this->user->query()->make()->fill(
            array_merge(
                array_only($data,['name','email']),
                [
                    'password' => Hash::make($password),
                    'api_token' => bcrypt(str_random(10))
                ]
            )
        );

        if ($user) {
            return $user->save();
        }

        return false;
    }


    /**
     * Update User model
     *
     * @param $email
     * @return bool
     */
    public function resetPwd($email): bool
    {
        $pwd = ResetPassword::query()->make()->fill(
            [
                'email' => $email,
                'token' => bcrypt(str_random(10)),
                'created_at' => date("Y-m-d H:i:s"),
            ]
        );

        if ($pwd) {
            return $pwd->save();
        }

        return false;
    }


    /**
     * Get name of User`s table
     *
     * @return string
     */
    public function getUserTableName(): string
    {
        return $this->user->getTable();
    }
}
