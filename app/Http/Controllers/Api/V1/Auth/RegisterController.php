<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

/**
 * @group Auth endpoints
 */
class RegisterController extends Controller
{
    /**
     * POST Register
     *
     * Register the new user (without role).
     *
     * @response {"access_token":"1|a9ZcYzIrLURVGx6Xe41HKj1CrNsxRxe4pLA2oISo"}
     * * @response 422 {"error": "The name is required."}
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        $device = substr($request->userAgent() ?? '', 0, 255);
        $access_token = $user->createToken($device)->plainTextToken;

        return (new UserResource($user))
            ->additional([
                'access_token' => $access_token
            ]);
    }
}
