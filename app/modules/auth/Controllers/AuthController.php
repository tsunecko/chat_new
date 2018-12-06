<?php

namespace App\modules\auth\Controllers;

use App\Http\Controllers\Controller;
use App\modules\auth\Services\UserService;
use App\modules\auth\Resources\UserResource;
use App\modules\auth\Requests\ResetRequest;
use App\modules\auth\Requests\RegisterRequest;
use App\modules\auth\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * the model instance
     * @var UserService
     */
    private $userService;


    /**
     * Create a new authentication controller instance.
     *
     * @param UserService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @return UserResource
     */
    public function register(RegisterRequest $request)
    {
        $newUser = $this->userService->create($request->validated());

        if (!$newUser) {
            abort(422, 'failed to create new user');
        }

        return $this->auth($request->only('name', 'password'));
    }


    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return UserResource
     */
    public function login(LoginRequest $request)
    {
        return $this->auth($request->only('name', 'password'));
    }


    /**
     * Handle a login request to the application.
     *
     * @param ResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetRequest $request)
    {
        $email = $request->input('email');
        $resetPwd = $this->userService->resetPwd($email);

        if (!$resetPwd) {
            abort(520, 'failed send token');
        }

        return response()->json(['check_email']);
    }

    /**
     * Auth User
     *
     * @param $data
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function auth($data)
    {
        //if (auth()->attempt($data)) {
            return UserResource::make($this->userService->one('name', $data['name']));
        //}

        //abort(401, 'Unauthorized user');
    }

}
