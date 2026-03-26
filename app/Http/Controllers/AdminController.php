<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Channel;
use App\Models\Message;
use App\Models\Ticket;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'channels' => Channel::count(),
            'messages' => Message::count(),
            'tickets' => Ticket::count(),
            'open_tickets' => Ticket::where('status', 'open')->count(),
            'resolved_tickets' => Ticket::whereIn('status', ['resolved', 'closed'])->count(),
        ];

        $recentTickets = Ticket::with(['creator', 'assignee'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $ticketsByStatus = Ticket::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $ticketsByPriority = Ticket::selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority');

        return view('admin-dashboard', compact('stats', 'recentTickets', 'ticketsByStatus', 'ticketsByPriority'));
    }

    public function users()
    {
        $users = User::withCount(['messages', 'tickets'])->get();
        return view('admin-users', compact('users'));
    }

    public function audit()
    {
        $logs = AuditLog::with('admin')->orderByDesc('created_at')->get();
        return view('admin-audit', compact('logs'));
    }
}
