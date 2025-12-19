<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

<form method="POST" action="/login"
      class="bg-white w-full max-w-sm p-6 rounded-xl shadow space-y-4">
    @csrf

    <h2 class="text-xl font-bold text-center">Admin Login</h2>

    @error('login')
        <p class="text-red-600 text-sm text-center">{{ $message }}</p>
    @enderror

    <input type="text" name="username" placeholder="Username"
           class="w-full rounded border px-3 py-2" required>

    <input type="password" name="password" placeholder="Password"
           class="w-full rounded border px-3 py-2" required>

    <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
        Login
    </button>
</form>

</body>
</html>
