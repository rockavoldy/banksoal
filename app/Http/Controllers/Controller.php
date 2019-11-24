<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 86000
        ], 200);
    }

    protected function is_guru()
    {
        if (Auth::user()->roles !== "guru") {
            die();
            return response()->json(['message' => 'Not have enough permissions to do this'], 401);
        }
        return true;
    }
}
