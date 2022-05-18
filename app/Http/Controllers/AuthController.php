<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            if($token = Auth::attempt(['email' => $request->email , 'password' => $request->password])){
                return response()->json([ 'token' => $token]);
            }
            return response()->json(['status' => 2, 'code' => 400, 'message' => "Wrong Email or Password"]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'message' => $th->getMessage()]);
        }
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json(['status' => 2, 'code' => 400, 'message' => 'Successfully logged out']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 2, 'code' => 400, 'message' => $th->getMessage()]);
        }
    }
}