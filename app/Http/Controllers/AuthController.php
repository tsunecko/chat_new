<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
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
    public function __construct()
    {
        $this->userService = new UserService();
    }


    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @return UserResource
     */
    public function register(RegisterRequest $request)
    {
        $newUser = $this->userService->createUser($request);

        if (!$newUser) {
            return response()->json(['failed_to_create_new_user']);
        }

        return $this->auth($request);
    }


    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return UserResource
     */
    public function login(LoginRequest $request)
    {
        return $this->auth($request);
    }


    /**
     * Handle a login request to the application.
     *
     * @param ForgotRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(ForgotRequest $request)
    {
        $userEmail = $request->get('email');
        $user = $this->userService->getUser('email', $userEmail);

        $newToken = str_random(20);
        $updUser = $this->userService->updateUser($user, 'token', $newToken);

        if (!$updUser) {
            return response()->json(['failed_to_send_token']);
        }

        return response()->json(['check_email']);
    }

    /**
     * Auth User
     *
     * @param $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function auth($request)
    {
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            return new UserResource(Auth::user());
        }

        return response()->json(['failed_login']);
    }

}
