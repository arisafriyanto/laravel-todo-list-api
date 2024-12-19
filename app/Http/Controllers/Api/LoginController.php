<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email'     => 'required|email',
        //     'password'  => 'required|min:8'
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        // }

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'errors' => 'Email or password wrong'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data'    => auth()->guard('api')->user(),
            'message' => 'Login success',
            'token'   => $token
        ], 200);
    }
}
