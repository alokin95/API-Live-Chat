<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function contacts()
    {
        return response()->json([
            'contacts' => User::all()
        ], 200);
    }

    public function auth()
    {
        return response()->json([
            'user' => auth()->user()
        ], 200);
    }
}
