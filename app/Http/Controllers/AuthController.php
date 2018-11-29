<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\ResetRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

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

//        $userService->getAll();

//        $this->userService = new UserService();
    }


    /**
     * Handle a registration request for the application.
     *
     * @param RegisterRequest $request
     * @return UserResource
     */
    public function register(RegisterRequest $request)
    {


//        $request->get('email');
//        $request->input('email');
//        $request->email;



        $newUser = $this->userService->createUser($request->validated());


        if (!$newUser) {
//            abort(422, 'filed user created');
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
     * @param ResetRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(ResetRequest $request)
    {
        $email = $request->get('email');

        $token = bcrypt(str_random(10));
        $resetPwd = $this->userService->resetPwd($email, $token);

        if (!$resetPwd) {
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
        //$credentials = $request->only('name', 'password');

        //if (Auth::attempt($credentials)) {
            return UserResource::make($this->userService->one($request->get('name')));
//            return new UserResource(Auth::user());
        //}

        //return response()->json(['failed_login']);
    }

}
