<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{
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
