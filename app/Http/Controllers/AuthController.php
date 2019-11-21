<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  /**
   * Get a JWT via given credentials.
   *
   * @param  Request  $request
   * @return Response
   */
  public function login(Request $request)
  {
    //validate incoming request 
    $this->validate($request, [
      'username' => 'required|string',
      'password' => 'required|string',
    ]);

    $credentials = $request->only(['username', 'password']);

    if (!$token = Auth::attempt($credentials)) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
  }

  /**
   * Register new User
   * @param Request $request
   * @return Response
   */
  public function register(Request $request)
  {
    // validate incoming request
    $this->validate($request, [
      'username' => 'required|string|unique:users',
      'name' => 'required',
      'password' => 'required|confirmed'
    ]);

    $user = new User();

    $user->username = $request->username;
    $user->name = $request->name;
    $user->password = password_hash($request->password, PASSWORD_BCRYPT);
    $user->roles = 'siswa';

    if (!$user->save()) {
      return response()->json(['message' => 'Can not create user right now'], 404);
    }

    $credentials = $request->only(['username', 'password']);

    if (!$token = Auth::attempt($credentials)) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    return $this->respondWithToken($token);
  }

  /**
   * Show user info
   * @return Response
   */
  public function me()
  {
    return response()->json(['user' => Auth::user()], 200);
  }
}
