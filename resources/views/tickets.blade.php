@extends('layout')
@section('content')
<div class="flex-1 overflow-y-auto">
    {{-- Header --}}
    <div class="px-8 py-6 border-b border-gray-200 bg-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Support Tickets</h1>
                <p class="text-sm text-gray-500 mt-1">Track and manage internal support requests</p>
            </div>
            <a href="/tickets/create" class="px-4 py-2 bg-sky-600 text-white rounded-lg text-sm font-medium hover:bg-sky-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Ticket
            </a>
        </div>

        {{-- Status filter tabs --}}
        <div class="flex gap-2 mt-4">
            <a href="/tickets" class="px-3 py-1.5 rounded-full text-xs font-medium {{ !request('status') ? 'bg-sky-100 text-sky-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                All ({{ $tickets->count() }})
            </a>
            @foreach(['open' => 'Open', 'in_progress' => 'In Progress', 'waiting' => 'Waiting', 'resolved' => 'Resolved', 'closed' => 'Closed'] as $key => $label)
                <a href="/tickets?status={{ $key }}" class="px-3 py-1.5 rounded-full text-xs font-medium {{ request('status') === $key ? 'bg-sky-100 text-sky-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
                </a>
            @endforeach
        </div>
    </div>

    {{-- Ticket list --}}
    <div class="px-8 py-4">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Requester</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Priority</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Assigned</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Replies</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='/tickets/{{ $ticket->id }}'">
                            <td class="px-4 py-3">
                                <span class="text-sm font-mono text-sky-600">{{ $ticket->reference }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm font-medium text-gray-900">{{ $ticket->subject }}</span>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $ticket->category }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-600">{{ $ticket->creator->name }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($ticket->priority === 'urgent') bg-red-100 text-red-700
                                    @elseif($ticket->priority === 'high') bg-amber-100 text-amber-700
                                    @elseif($ticket->priority === 'medium') bg-sky-100 text-sky-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($ticket->status === 'open') bg-sky-100 text-sky-700
                                    @elseif($ticket->status === 'in_progress') bg-amber-100 text-amber-700
                                    @elseif($ticket->status === 'waiting') bg-purple-100 text-purple-700
                                    @elseif($ticket->status === 'resolved') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-600
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-600">{{ $ticket->assignee?->name ?? '—' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-sm text-gray-500">{{ $ticket->replies_count }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
