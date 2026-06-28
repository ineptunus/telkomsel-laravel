<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-black via-slate-950 to-sky-950 flex items-center justify-center">

<div class="bg-white/95 w-full max-w-md rounded-2xl shadow-2xl p-8">

    <div class="text-center mb-8">
        <div class="mx-auto w-16 h-16 bg-sky-500 rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-lg">
            T
        </div>
        <h1 class="text-2xl font-bold mt-5 text-slate-900">Telkomsel X Analytics</h1>
        <p class="text-slate-500 mt-2 text-sm">Customer Satisfaction Analysis System</p>
    </div>

    @if(session('error'))
        <div class="bg-red-100 text-red-600 p-3 rounded-lg mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <label class="block font-semibold text-sm mb-2 text-slate-700">Email Admin</label>
        <div class="relative mb-5">
            <span class="absolute left-4 top-3 text-slate-400">✉</span>
            <input type="email" name="email"
                class="w-full border border-slate-300 rounded-lg py-3 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-sky-400"
                placeholder="admin@telkomsel.co.id" required>
        </div>

        <label class="block font-semibold text-sm mb-2 text-slate-700">Password</label>
        <div class="relative mb-5">
            <span class="absolute left-4 top-3 text-slate-400">🔒</span>
            <input type="password" name="password"
                class="w-full border border-slate-300 rounded-lg py-3 pl-11 pr-4 focus:outline-none focus:ring-2 focus:ring-sky-400"
                placeholder="Masukkan password" required>
        </div>

        <div class="flex justify-between items-center mb-6 text-sm">
            <label class="flex items-center gap-2 text-slate-600">
                <input type="checkbox" class="rounded">
                Ingat saya
            </label>
            <a href="#" class="text-sky-500 font-semibold">Lupa password?</a>
        </div>

        <button class="w-full bg-sky-500 hover:bg-sky-600 text-white py-3 rounded-lg font-bold shadow-lg">
            Login
        </button>
    </form>

    <p class="text-center text-sm mt-5 text-slate-600">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-sky-500 font-bold">Register Customer Service</a>
    </p>

    <p class="text-center text-xs text-slate-500 mt-6">
        © 2026 Telkomsel. Powered by CNN-LSTM + FastText
    </p>
</div>

</body>
</html>