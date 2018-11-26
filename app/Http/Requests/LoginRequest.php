<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\Password;

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
     * @return array
     */
    public function rules()
    {
        $user = User::where('token', Helper::getToken(request()))
            ->select('password')
            ->first();

        return [
            'name' => 'required|string|max:255',
            'password' => ['required', 'max:255', 'min:6', 'string', new Password($user->password)],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
