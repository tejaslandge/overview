<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Authentication | Shops Digital Ads</title>
    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top right, #f8fafc, #eff6ff);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }

        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 antialiased">

    <!-- Decorative Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div
            class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse">
        </div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"
            style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full max-w-md">
        <!-- Logo Header -->
        <div class="text-center mb-10 animate-float">
            <div class="inline-flex p-4 rounded-3xl bg-white shadow-xl mb-6">
                <img src="{{ asset('assets/logo_icon.png') }}" class="h-12 w-auto" alt="Logo">
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Welcome Back</h1>
            <p class="text-slate-500 font-medium">Please sign in to access the command center</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-[2.5rem] p-10">
            <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                @csrf

                @error('login')
                    <div
                        class="p-4 rounded-2xl bg-red-50 border border-red-100 text-red-600 text-sm font-bold flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror

                <!-- Username -->
                <div>
                    <label
                        class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-slate-900 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="username" required placeholder="admin_user"
                            class="input-focus w-full pl-14 pr-6 py-4 rounded-2xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none font-bold text-slate-900">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Secret
                        Key</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-slate-900 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required placeholder="••••••••"
                            class="input-focus w-full pl-14 pr-14 py-4 rounded-2xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none font-bold text-slate-900">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-slate-900 transition-colors">
                            <svg id="eye-icon" class="h-6 w-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Action Button -->
                <button type="submit"
                    class="w-full py-5 rounded-[1.5rem] bg-slate-900 text-white text-sm font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-900/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Initiate Access
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="mt-10 text-center text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">
            © {{ date('Y') }} Shops Digital Ads — Brando Digitech Pvt. Ltd.
        </p>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eye-icon');

            if (password.type === 'password') {
                password.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                `;
            } else {
                password.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }
    </script>
</body>

</html>
