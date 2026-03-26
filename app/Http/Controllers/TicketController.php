<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['creator', 'assignee'])->withCount('replies');

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($priority = $request->query('priority')) {
            $query->where('priority', $priority);
        }

        $tickets = $query->orderByDesc('created_at')->get();
        $statusCounts = Ticket::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');

        return view('tickets', compact('tickets', 'statusCounts'));
    }

    public function create()
    {
        $users = User::where('role', 'admin')->get();
        return view('ticket-create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'category' => 'required|in:technical,billing,general,access',
        ]);

        $lastRef = Ticket::orderByDesc('id')->value('reference');
        $nextNum = $lastRef ? ((int) substr($lastRef, 7)) + 1 : 1;

        Ticket::create([
            'reference' => 'TICKET-' . str_pad($nextNum, 6, '0', STR_PAD_LEFT),
            'user_id' => Auth::id(),
            'subject' => $data['subject'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'category' => $data['category'],
            'status' => 'open',
        ]);

        return redirect('/tickets')->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['creator', 'assignee', 'replies.user']);
        return view('ticket-detail', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate(['body' => 'required|string|max:5000']);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect('/tickets/' . $ticket->id);
    }
}
