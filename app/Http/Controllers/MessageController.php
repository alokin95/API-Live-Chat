<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use App\Events\MessageSent;

class MessageController extends Controller
{

    private function markAsRead()
    {
        Message::where([
            'from' => request()->user,
            'to' => auth()->user()->id
        ])->update(['read' => true]);
    }

    public function index()
    {
        $this->markAsRead();

        $messages = Message::where(function ($query)
        {
            $query->where([
                'from' => auth()->user()->id,
                'to' => request()->user
            ]);
        })
            ->orWhere(function ($query)
            {
                $query->where([
                    'from' => request()->user,
                    'to' => auth()->user()->id
                ]);

            })->get();

        return response()->json([
            'messages' => $messages
        ], 200);
    }

    public function store()
    {
        $this->markAsRead();

        request()->validate([
            'message' => 'required',
            'user' => 'required'
        ]);

        $message = Message::create([
            'to' => request('user')['id'],
            'from' => auth()->user()->id,
            'message' => request()->message
        ]);

        MessageSent::dispatch($message);
        
        return response()->json([
            'message' => $message
        ], 201);

    }

}
