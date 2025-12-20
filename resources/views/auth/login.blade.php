<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <link rel="shortcut icon" href="{{ asset('assets/logo_icon.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        <!-- Card -->
        <form method="POST" action="/login" class="bg-white rounded-2xl shadow-xl p-8 space-y-6">

            @csrf

            <!-- Brand -->
            <div class="text-center space-y-2">
                <div
                    class="mx-auto w-12 h-12 rounded-full bg-white border border-slate-200
           flex items-center justify-center shadow-sm">
                    <img src="{{ asset('assets/logo_icon.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                </div>

                <h2 class="text-2xl font-semibold tracking-tight">
                    Admin Login
                </h2>
                <p class="text-sm text-slate-500">
                    Sign in to manage videos
                </p>
            </div>

            <!-- Error -->
            @error('login')
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-2">
                    {{ $message }}
                </div>
            @enderror

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Username
                </label>
                <input type="text" name="username" required
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800
                           transition">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Password
                </label>
                <input type="password" name="password" required
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5
                           focus:outline-none focus:ring-2 focus:ring-slate-800 focus:border-slate-800
                           transition">
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-slate-900 text-white py-2.5 rounded-lg font-medium
                       hover:bg-slate-800 active:scale-[0.98]
                       transition">
                Sign In
            </button>

        </form>

        <!-- Footer -->
        <p class="mt-6 text-center text-xs text-slate-500">
            © {{ date('Y') }} Shops Digital Ads. Admin access only.
        </p>

    </div>

</body>

</html>
