<?php

namespace App\Rules;

use App\Services\UserService;
use Illuminate\Contracts\Validation\Rule;

class Email implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $userService = new UserService;
        return !!$userService->one($attribute, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User is not found';
    }
}
