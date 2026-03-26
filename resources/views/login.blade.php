<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Comms</title>
    <script src="/js/tailwind.js"></script>
    <link rel="stylesheet" href="/css/inter.css">
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="min-h-screen flex">
        {{-- Left: Login form --}}
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="w-full max-w-sm">
                <div class="flex items-center gap-2 mb-8">
                    <div class="w-10 h-10 bg-sky-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Comms</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-1">Welcome back</h1>
                <p class="text-gray-500 mb-6">Sign in to your workspace</p>

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="/login" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="demo@comms.com" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" value="demo2026" required
                            class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm">
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-sky-600 text-white rounded-lg font-medium hover:bg-sky-700 transition text-sm">
                        Sign In
                    </button>
                </form>

                <p class="mt-6 text-xs text-gray-400 text-center">Demo credentials are prefilled for your convenience</p>
            </div>
        </div>

        {{-- Right: Feature panel --}}
        <div class="hidden lg:flex flex-1 bg-gradient-to-br from-sky-600 to-sky-800 text-white items-center justify-center p-12">
            <div class="max-w-md">
                <h2 class="text-3xl font-bold mb-6">Internal Communication & Support</h2>
                <p class="text-sky-100 mb-8 text-base leading-relaxed">A unified platform for team messaging, support tickets, and compliance-grade audit trails.</p>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Channel-Based Messaging</p>
                            <p class="text-sky-200 text-sm">Organized conversations with public, private, and direct channels</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Support Ticket System</p>
                            <p class="text-sky-200 text-sm">Track, assign, and resolve internal support requests</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">Compliance Audit Trail</p>
                            <p class="text-sky-200 text-sm">Full transparency on all timestamp modifications with admin accountability</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
