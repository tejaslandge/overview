<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Logs | Professional Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        pre {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }

        pre::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        pre::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        pre::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .log-entry {
            transition: all 0.2s ease;
        }

        .log-error {
            color: #ef4444;
        }

        .log-warning {
            color: #f59e0b;
        }

        .log-info {
            color: #3b82f6;
        }
    </style>
</head>

<body class="min-h-screen antialiased">

    <main class="max-w-7xl mx-auto px-4 sm:px-8 py-10">

        <!-- Header Section -->
        <header class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('admin.dashboard') }}"
                        class="text-slate-400 hover:text-slate-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">System Logs</h1>
                </div>
                <p class="text-slate-500 font-medium ml-9">Monitor and debug application errors in real-time</p>
            </div>

            <button onclick="copyLogs()"
                class="px-8 py-4 rounded-2xl bg-white text-slate-700 text-sm font-bold shadow-sm border border-slate-200 hover:shadow-md transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3" />
                </svg>
                Copy Logs
            </button>
            <form action="{{ route('admin.logs.destroy') }}" method="POST"
                onsubmit="return confirm('Are you sure you want to clear all logs?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-8 py-4 rounded-2xl bg-red-50 text-red-600 text-sm font-bold hover:bg-red-100 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Clear Logs
                </button>
            </form>
            </div>
        </header>

        @if (session('success'))
            <div class="mb-8 p-4 rounded-2xl bg-emerald-50 text-emerald-700 font-bold border border-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-8 p-4 rounded-2xl bg-red-50 text-red-700 font-bold border border-red-100">
                {{ session('error') }}
            </div>
        @endif

        <!-- Logs Container -->
        <section class="glass-panel rounded-[2.5rem] overflow-hidden shadow-sm">
            <div class="bg-slate-900 px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <span class="ml-4 text-slate-400 text-xs font-mono font-bold tracking-widest uppercase">laravel.log
                        — Last 100 lines</span>
                </div>
                <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">Read Only Mode</span>
            </div>

            <div class="p-8 bg-slate-50/50">
                @if (count($logs) > 0)
                    <div id="logContainer" class="space-y-1 font-mono text-sm leading-relaxed">
                        @foreach ($logs as $log)
                            @php
                                $class = '';
                                if (str_contains($log, '.ERROR')) {
                                    $class = 'log-error bg-red-50/50';
                                } elseif (str_contains($log, '.WARNING')) {
                                    $class = 'log-warning bg-amber-50/50';
                                } elseif (str_contains($log, '.INFO')) {
                                    $class = 'log-info bg-blue-50/50';
                                }
                            @endphp
                            <div
                                class="log-item whitespace-pre-wrap break-all p-1 rounded {{ $class }} hover:bg-slate-100 transition-colors">
                                {{ $log }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-20 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-slate-400 font-bold">No log entries found.</p>
                    </div>
                @endif
            </div>
        </section>

        <footer class="mt-12 text-center text-slate-400 text-xs font-medium">
            <p>© {{ date('Y') }} System Administration — Debugging Interface</p>
        </footer>

    </main>

    <script>
        function copyLogs() {
            const items = document.querySelectorAll('.log-item');
            if (items.length === 0) return;

            const content = Array.from(items).map(item => item.innerText).join('');

            navigator.clipboard.writeText(content).then(() => {
                const btn = event.currentTarget;
                const originalText = btn.innerHTML;
                btn.innerHTML = `
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Copied!
                `;
                setTimeout(() => {
                    btn.innerHTML = originalText;
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>

</body>

</html>
