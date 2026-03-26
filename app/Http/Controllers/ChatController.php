<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $channels = $user->channels()->withCount('messages')->get();
        $activeChannel = $request->query('channel')
            ? Channel::find($request->query('channel'))
            : $channels->first();

        if (!$activeChannel) {
            abort(404);
        }

        $messages = $activeChannel->messages()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(fn($msg) => $msg->created_at->format('Y-m-d'));

        return view('chat', compact('channels', 'activeChannel', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'channel_id' => 'required|exists:channels,id',
            'body' => 'required|string|max:5000',
        ]);

        Message::create([
            'channel_id' => $request->channel_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect('/chat?channel=' . $request->channel_id);
    }
}
