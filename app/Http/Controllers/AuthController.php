<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    public function store()
    {

        $validated = \Validator::make(request()->user, [
            'username' => 'required|min:3|unique:users,username',
            'password' => 'required|min:5|max:30|confirmed'
        ])->validate();

        $validated['password'] = bcrypt($validated['password']);

        $user = new User($validated);

        if ($user->save())
        {
            $token = auth()->login($user);

            return response()->json([
                'token' => $token
            ], 201);
        }

    }

    public function login()
    {
        $token = auth()->attempt([
            'username' => request('user')['username'],
            'password' => request('user')['password']
        ]);

        if ($token)
        {
            return response()
                ->json([
                    'token' => $token
                ], 200);
        }

        return response()
            ->json([
                'message' => 'User not found'
            ], 403);
    }
}
