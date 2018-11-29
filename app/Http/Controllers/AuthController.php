<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\ResetRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

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
        //$credentials = $request->only('name', 'password');

        //if (Auth::attempt($credentials)) {
            return UserResource::make($this->userService->one('name', $data['name']));
        //}

        //return response()->json(['failed_login']);
    }

}
