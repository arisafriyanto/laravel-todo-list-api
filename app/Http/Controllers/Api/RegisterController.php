<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create([
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'username'      => $request->username,
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'data'    => $user,
                'message' => 'Register success'
            ], 201);
        }

        return response()->json([
            'success' => false,
            'errors' => 'Register failed'
        ], 500);
    }
}
