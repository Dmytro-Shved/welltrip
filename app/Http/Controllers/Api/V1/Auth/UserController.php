<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

/**
 * @group User endpoints
 *
 *  User
 */
class UserController extends Controller
{
    /**
     * GET Current user
     *
     * Get the currently authenticated user.
     *
     * @authenticated
     * @response 200 {"user": {"id": 1, "name": "John", "email": "john@doe.com"}}
     * @response 401 {"message": "Unauthorized"}
     */
    public function __invoke(Request $request)
    {
        return (new UserResource($request->user()));
    }
}
