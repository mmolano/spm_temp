<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()
            ->json(User::all());
    }

    public function show(Request $request): JsonResponse
    {
        $user = User::where('id', $request->id)
            ->with('posts')
            ->first();
        if (!$user) {
            return response()->json([
                'status' => 400,
                'message' => 'Error show'
            ], 400);
        }
        return response()
            ->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'email' => ['email', 'unique:User'],
            'password' => ['string'],
        ]);

        if (!$user = User::where('id', $request->id)->first()) {
            return response()->json([
                'status' => 400,
                'message' => 'Error show'
            ], 400);
        } elseif ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => json_encode($validation->errors())
            ], 400);
        }

        $user->update($request->all());
        
        return response()
            ->json($user);
    }
}
