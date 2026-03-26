@extends('layout')
@section('content')
<div class="flex-1 overflow-y-auto">
    <div class="px-8 py-6 border-b border-gray-200 bg-white">
        <h1 class="text-xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Platform overview and statistics</p>
    </div>

    <div class="px-8 py-6 space-y-6">
        {{-- Stats cards --}}
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['users'] }}</p>
                        <p class="text-xs text-gray-500">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['messages'] }}</p>
                        <p class="text-xs text-gray-500">Messages</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['open_tickets'] }}</p>
                        <p class="text-xs text-gray-500">Open Tickets</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['resolved_tickets'] }}</p>
                        <p class="text-xs text-gray-500">Resolved</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            {{-- Tickets by status --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Tickets by Status</h2>
                <div class="space-y-3">
                    @php
                        $statusColors = ['open' => 'sky', 'in_progress' => 'amber', 'waiting' => 'purple', 'resolved' => 'green', 'closed' => 'gray'];
                        $total = max(array_sum($ticketsByStatus->toArray()), 1);
                    @endphp
                    @foreach($statusColors as $status => $color)
                        @php $count = $ticketsByStatus[$status] ?? 0; @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">{{ str_replace('_', ' ', ucfirst($status)) }}</span>
                                <span class="font-medium text-gray-900">{{ $count }}</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $color }}-500 rounded-full" style="width: {{ ($count / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tickets by priority --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Tickets by Priority</h2>
                <div class="space-y-3">
                    @php
                        $priorityColors = ['urgent' => 'red', 'high' => 'amber', 'medium' => 'sky', 'low' => 'gray'];
                    @endphp
                    @foreach($priorityColors as $priority => $color)
                        @php $count = $ticketsByPriority[$priority] ?? 0; @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">{{ ucfirst($priority) }}</span>
                                <span class="font-medium text-gray-900">{{ $count }}</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $color }}-500 rounded-full" style="width: {{ ($count / $total) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent tickets --}}
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-900">Recent Tickets</h2>
            </div>
            <table class="w-full">
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentTickets as $ticket)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location='/tickets/{{ $ticket->id }}'">
                            <td class="px-5 py-3">
                                <span class="text-sm font-mono text-sky-600">{{ $ticket->reference }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm font-medium text-gray-900">{{ $ticket->subject }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm text-gray-600">{{ $ticket->creator->name }}</span>
                            </td>
                            <td class="px-5 py-3">
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
                            <td class="px-5 py-3 text-right">
                                <span class="text-xs text-gray-400">{{ $ticket->created_at->diffForHumans() }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
