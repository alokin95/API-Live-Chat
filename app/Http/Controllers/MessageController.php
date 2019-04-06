<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;

class MessageController extends Controller
{

    public function index()
    {

        $messages = Message::where([
            'from' => auth()->user()->id,
            'to' => request()->user
        ])->get();

        $messages = Message::all();

        return response()->json([
            'messages' => $messages
        ], 200);
    }

    public function store()
    {
//        dd(request()->all());
        request()->validate([
            'message' => 'required',
            'user' => 'required'
        ]);

        Message::create([
            'to' => request('user')['id'],
            'from' => auth()->user()->id,
            'message' => request()->message
        ]);
    }

}
