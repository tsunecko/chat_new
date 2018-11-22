<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{

    /**
     * the model instance
     * @var User
     */
    private $user;


    /**
     * Create a new authentication controller instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @return Response
     */
    public function register(RegisterRequest $request)
    {
        $newUser = $this->user->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'token' => str_random(20),
        ]);

        if (!$newUser) {
            return response()->json(['failed_to_create_new_user']);
        }

        return response()
            ->json(['user_created'])
            ->header('Authorization', 'Basic'. $newUser->token);
    }


    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     * @return Response
     */
    public function login(LoginRequest $request)
    {
        return response()->json(['user_login']);
    }


    /**
     * Handle a login request to the application.
     *
     * @param ForgotRequest $request
     * @return Response
     */
    public function forgot(ForgotRequest $request)
    {
        $updUser = $this->user
            ->where('email', $request->get('email'))
            ->update(['token' => str_random(20)]);

        if (!$updUser) {
            return response()->json(['failed_to_send_token']);
        }

        return response()->json(['check_email']);
    }
}
