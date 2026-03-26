@extends('layout')
@section('content')
<div class="flex-1 overflow-y-auto">
    <div class="px-8 py-6 border-b border-gray-200 bg-white">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Audit Log</h1>
                <p class="text-sm text-gray-500">Complete record of all timestamp modifications for compliance</p>
            </div>
        </div>
    </div>

    <div class="px-8 py-6">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Record Type</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Record ID</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Original Time</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Modified To</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reason</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <span class="text-sm font-mono text-gray-500">#{{ $log->id }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-sky-100 text-sky-700 rounded-full flex items-center justify-center text-xs font-semibold">
                                        {{ $log->admin->initials }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $log->admin->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex px-2 py-0.5 rounded text-xs font-medium font-mono
                                    @if($log->auditable_type === 'message') bg-indigo-50 text-indigo-700
                                    @else bg-amber-50 text-amber-700
                                    @endif">
                                    {{ $log->auditable_type }}
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-sm font-mono text-gray-600">#{{ $log->auditable_id }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-sm text-gray-600">{{ $log->original_timestamp->format('M j, Y g:i A') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span class="text-sm font-medium text-gray-900">{{ $log->modified_timestamp->format('M j, Y g:i A') }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm text-gray-600 max-w-xs">{{ $log->reason ?? '—' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-xs text-gray-400">{{ $log->created_at->format('M j, Y') }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4 bg-sky-50 border border-sky-200 rounded-lg">
            <div class="flex items-start gap-2">
                <svg class="w-4 h-4 text-sky-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-sky-800">This log records every timestamp modification made by administrators. All entries are immutable and cannot be edited or deleted, ensuring full compliance transparency.</p>
            </div>
        </div>
    </div>
</div>
@endsection
