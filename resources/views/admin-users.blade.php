@extends('layout')
@section('content')
<div class="flex-1 overflow-y-auto">
    <div class="px-8 py-6 border-b border-gray-200 bg-white">
        <h1 class="text-xl font-bold text-gray-900">User Management</h1>
        <p class="text-sm text-gray-500 mt-1">All registered users and their activity</p>
    </div>

    <div class="px-8 py-6">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Messages</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tickets</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold
                                        @if($user->role === 'admin') bg-sky-100 text-sky-700 @else bg-gray-100 text-gray-600 @endif">
                                        {{ $user->initials }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm text-gray-600">{{ $user->email }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($user->role === 'admin') bg-sky-100 text-sky-700 @else bg-gray-100 text-gray-600 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm text-gray-600">{{ $user->messages_count }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm text-gray-600">{{ $user->tickets_count }}</span>
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm text-gray-400">{{ $user->created_at->format('M j, Y') }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
