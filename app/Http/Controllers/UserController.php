<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function contacts()
    {
        $users = User::withCount(['sentMessages' => function ($query){
           $query->where('to', auth()->user()->id);
           $query->where('read', false);
        }])
            ->where('id','!=', auth()->user()->id)->get();


        return response()->json([
            'contacts' => $users
        ], 200);
    }

    public function auth()
    {
        return response()->json([
            'user' => auth()->user()
        ], 200);
    }
}
