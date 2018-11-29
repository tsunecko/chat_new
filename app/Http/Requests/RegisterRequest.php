<?php

namespace App\Http\Requests;

use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255|unique:'. $userService->getTableName() .',name',
            'email' => 'required|email|unique:'. $userService->getTableName() .',email|max:255',
            'password' => 'required|max:255|min:6|confirmed|string',
        ];
    }
}
