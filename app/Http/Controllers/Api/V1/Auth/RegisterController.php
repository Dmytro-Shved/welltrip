<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth endpoints
 *
 *  Authentication
 */
class RegisterController extends Controller
{
    /**
     * POST Register
     *
     * Register the new user (without role).
     *
     * @response {"user": {"id": 1, "name": "John", "email": "john@doe.com"}}
     * @response 422 {"message": "The given data was invalid.", "errors": {"email": ["The email has already been taken."]}}
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        Auth::login($user);

        $request->session()->regenerate();

        return (new UserResource($user));
    }
}
