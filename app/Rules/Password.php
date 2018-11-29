<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class Password implements Rule
{

    private $pwd;


    /**
     * Create a new rule instance.
     *
     * @param $user
     */
    public function __construct($user)
    {
        if ($user) {
            $this->pwd = $user->password;
        }
        return false;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->pwd);
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The name or the password is wrong';
    }
}
