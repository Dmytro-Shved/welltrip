<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Auth endpoints
 *
 *  Authentication
 */
class LogoutController extends Controller
{
    /**
     * POST Logout
     *
     * Logout the user.
     *
     * @response 200 {"message": "Logged out"}
     * @response 401 {"message": "Unauthenticated"}
     */
    public function __invoke(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
           'message' => 'Logged out'
        ]);
    }
}
