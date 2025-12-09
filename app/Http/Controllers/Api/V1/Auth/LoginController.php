<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth endpoints
 *
 *  Authentication
 */
class LoginController extends Controller
{
    /**
     * POST Login
     *
     * Login with the existing user.
     *
     * @unauthenticated
     * @bodyParam email string required The user's email. Example: john@doe.com
     * @bodyParam password string required The user's password. Example: password
     * @response {"user": {"id": 1, "name": "John", "email": "john@doe.com"}}
     * @response 422 {"message": "The provided credentials are incorrect"}
     */
    public function __invoke(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())){
            $request->session()->regenerate();

            return (new UserResource(Auth::user()));
        }else{
            return response()->json([
                'message' => 'The provided credentials are incorrect'
            ], 422);
        }
    }
}
