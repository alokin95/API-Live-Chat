<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function contacts()
    {

        $q = User::withCount(['sentMessages' => function ($query){
            $query->where('to', auth()->user()->id);
            $query->where('read', false);
        }])
            ->where('id','!=', auth()->user()->id);

        if (request()->has('q'))
        {
            $q->where('username', 'like', '%'.request()->q.'%');
        }

        $users = $q->get();

//        $users = User::withCount(['sentMessages' => function ($query){
//           $query->where('to', auth()->user()->id);
//           $query->where('read', false);
//        }])
//            ->where('id','!=', auth()->user()->id)->get();


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
