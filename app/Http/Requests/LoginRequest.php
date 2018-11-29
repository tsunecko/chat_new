<?php

namespace App\Http\Requests;

use App\Rules\Password;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @param UserService $userService
     * @return array
     */
    public function rules(UserService $userService)
    {
        $user = $userService->one('name', request('name'));

        return [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'max:255', 'min:6', 'string', new Password($user)],
        ];
    }
}
