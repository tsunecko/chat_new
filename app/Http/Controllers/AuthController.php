<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\ForgotRequest;
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
     * @param User $user
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $newUser = $this->userService->createUser($request);

        if (!$newUser) {
            return response()->json(['failed_to_create_new_user']);
        }

        return (new UserResource($newUser))
            ->response()
            ->header('Authorization', 'Basic'. $newUser->token);
    }


    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return UserResource
     */
    public function login(LoginRequest $request)
    {
        $token = substr($request->header('Authorization'), 5);
        $user = $this->userService->getUser('token', $token);

        return new UserResource($user);
    }


    /**
     * Handle a login request to the application.
     *
     * @param ForgotRequest $request
     * @return UserResource
     */
    public function forgot(ForgotRequest $request)
    {
        $user = $this->userService->getUser('email', $request->get('email'));
        $updUser = $this->userService->updateUser($user, 'token', str_random(20));

        if (!$updUser) {
            return response()->json(['failed_to_send_token']);
        }

        return new UserResource($user);
    }
}
