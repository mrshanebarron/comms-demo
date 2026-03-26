@extends('layout')
@section('content')
<div class="flex flex-1 overflow-hidden">
    {{-- Channel list --}}
    <div class="w-56 bg-white border-r border-gray-200 flex flex-col flex-shrink-0">
        <div class="p-3 border-b border-gray-200">
            <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Channels</h2>
        </div>
        <div class="flex-1 overflow-y-auto scrollbar-thin p-2 space-y-0.5">
            @foreach($channels as $channel)
                <a href="/chat?channel={{ $channel->id }}"
                   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm {{ $activeChannel->id === $channel->id ? 'bg-sky-50 text-sky-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                    @if($channel->type === 'direct')
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    @elseif($channel->type === 'private')
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    @else
                        <span class="text-gray-400 flex-shrink-0 text-base font-bold">#</span>
                    @endif
                    <span class="truncate">{{ $channel->name }}</span>
                    @if($channel->messages_count > 0)
                        <span class="ml-auto text-xs text-gray-400">{{ $channel->messages_count }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    {{-- Chat area --}}
    <div class="flex-1 flex flex-col bg-white">
        {{-- Channel header --}}
        <div class="px-6 py-3 border-b border-gray-200 flex items-center gap-3">
            @if($activeChannel->type === 'private')
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            @elseif($activeChannel->type === 'direct')
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            @else
                <span class="text-xl text-gray-400 font-bold">#</span>
            @endif
            <div>
                <h1 class="font-semibold text-base">{{ $activeChannel->name }}</h1>
                @if($activeChannel->description)
                    <p class="text-xs text-gray-500">{{ $activeChannel->description }}</p>
                @endif
            </div>
            <div class="ml-auto flex items-center gap-2 text-gray-400">
                <span class="text-xs">{{ $activeChannel->users->count() }} members</span>
            </div>
        </div>

        {{-- Messages --}}
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-1 scrollbar-thin" id="messages">
            @foreach($messages as $date => $dayMessages)
                {{-- Date divider --}}
                <div class="flex items-center gap-3 my-4">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-xs text-gray-400 font-medium">{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                @foreach($dayMessages as $message)
                    <div class="flex items-start gap-3 py-1.5 group hover:bg-gray-50 -mx-3 px-3 rounded-lg {{ $message->is_pinned ? 'bg-amber-50 border-l-2 border-amber-400 pl-4' : '' }}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold flex-shrink-0 mt-0.5
                            @if($message->user->role === 'admin') bg-sky-100 text-sky-700 @else bg-gray-100 text-gray-600 @endif">
                            {{ $message->user->initials }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-baseline gap-2">
                                <span class="font-semibold text-sm">{{ $message->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $message->created_at->format('g:i A') }}</span>
                                @if($message->is_pinned)
                                    <span class="text-xs text-amber-600 font-medium flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M5 5a2 2 0 012-2h6a2 2 0 012 2v2a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/><path d="M9 14v4l1 1 1-1v-4h3a1 1 0 000-2H6a1 1 0 000 2h3z"/></svg>
                                        Pinned
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $message->body }}</p>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        {{-- Message input --}}
        <div class="px-6 py-3 border-t border-gray-200">
            <form method="POST" action="/chat" class="flex items-end gap-3">
                @csrf
                <input type="hidden" name="channel_id" value="{{ $activeChannel->id }}">
                <div class="flex-1">
                    <textarea name="body" rows="1" placeholder="Message #{{ $activeChannel->name }}..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm resize-none"
                        onkeydown="if(event.key==='Enter'&&!event.shiftKey){event.preventDefault();this.form.submit()}"></textarea>
                </div>
                <button type="submit" class="px-4 py-2.5 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition text-sm font-medium">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
</script>
@endsection
