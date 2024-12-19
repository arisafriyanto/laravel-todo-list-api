<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // if (!$user) {
        //     return response()->json([
        //         'success' => false,
        //         'errors' => 'Unauthorized'
        //     ], 401);
        // }

        return response()->json([
            'success' => true,
            'data'    => $user,
            'message' => 'Get user success',
        ], 200);
    }
}
