@extends('layout')
@section('content')
<div class="flex-1 overflow-y-auto">
    <div class="max-w-3xl mx-auto px-8 py-8">
        {{-- Back link --}}
        <div class="mb-6">
            <a href="/tickets" class="text-sm text-sky-600 hover:text-sky-700 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Tickets
            </a>
        </div>

        {{-- Ticket header --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <span class="text-sm font-mono text-sky-600">{{ $ticket->reference }}</span>
                    <h1 class="text-lg font-bold text-gray-900 mt-1">{{ $ticket->subject }}</h1>
                </div>
                <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                    @if($ticket->status === 'open') bg-sky-100 text-sky-700
                    @elseif($ticket->status === 'in_progress') bg-amber-100 text-amber-700
                    @elseif($ticket->status === 'waiting') bg-purple-100 text-purple-700
                    @elseif($ticket->status === 'resolved') bg-green-100 text-green-700
                    @else bg-gray-100 text-gray-600
                    @endif">
                    {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                </span>
            </div>

            <p class="text-sm text-gray-700 leading-relaxed mb-4">{{ $ticket->description }}</p>

            <div class="grid grid-cols-4 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Requester</p>
                    <p class="text-sm font-medium mt-1">{{ $ticket->creator->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Assigned To</p>
                    <p class="text-sm font-medium mt-1">{{ $ticket->assignee?->name ?? 'Unassigned' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Priority</p>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium mt-1
                        @if($ticket->priority === 'urgent') bg-red-100 text-red-700
                        @elseif($ticket->priority === 'high') bg-amber-100 text-amber-700
                        @elseif($ticket->priority === 'medium') bg-sky-100 text-sky-700
                        @else bg-gray-100 text-gray-600
                        @endif">
                        {{ ucfirst($ticket->priority) }}
                    </span>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Category</p>
                    <p class="text-sm font-medium mt-1">{{ ucfirst($ticket->category) }}</p>
                </div>
            </div>
        </div>

        {{-- Replies thread --}}
        <div class="space-y-4 mb-6">
            <h2 class="text-sm font-semibold text-gray-900">Replies ({{ $ticket->replies->count() }})</h2>

            @forelse($ticket->replies as $reply)
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold
                            @if($reply->user->role === 'admin') bg-sky-100 text-sky-700 @else bg-gray-100 text-gray-600 @endif">
                            {{ $reply->user->initials }}
                        </div>
                        <div>
                            <span class="text-sm font-semibold">{{ $reply->user->name }}</span>
                            @if($reply->user->role === 'admin')
                                <span class="ml-1 px-1.5 py-0.5 bg-sky-100 text-sky-700 text-xs rounded font-medium">Admin</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 ml-auto">{{ $reply->created_at->format('M j, Y g:i A') }}</span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $reply->body }}</p>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 p-6 text-center text-gray-400 text-sm">
                    No replies yet
                </div>
            @endforelse
        </div>

        {{-- Reply form --}}
        @if(!in_array($ticket->status, ['closed']))
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Add Reply</h3>
                <form method="POST" action="/tickets/{{ $ticket->id }}/reply">
                    @csrf
                    <textarea name="body" rows="3" required
                        class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm resize-none mb-3"
                        placeholder="Write your reply..."></textarea>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-lg text-sm font-medium hover:bg-sky-700 transition">
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
