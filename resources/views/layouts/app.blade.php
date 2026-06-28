<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Telkomsel Analytics Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-50 font-sans overflow-hidden">

<div class="flex h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-[250px] bg-black text-white h-screen shrink-0 flex flex-col">

        <div class="p-6 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-sky-500 flex items-center justify-center font-bold text-xl">
                    T
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight">Telkomsel X</h1>
                    <p class="text-xs text-slate-400">Analytics Dashboard</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-5 space-y-2 text-sm font-semibold">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-sky-500' : 'hover:bg-slate-800' }}">
                Home
            </a>

            <a href="{{ route('statistik') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('statistik') ? 'bg-sky-500' : 'hover:bg-slate-800' }}">
                Statistik Kepuasan
            </a>

            <a href="{{ route('tren.sarcasm') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('tren.sarcasm') ? 'bg-sky-500' : 'hover:bg-slate-800' }}">
                Tren Sarcasm
            </a>

            <a href="{{ route('tren.hate') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('tren.hate') ? 'bg-sky-500' : 'hover:bg-slate-800' }}">
                Tren Hate Speech
            </a>

            <a href="{{ route('export') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('export') ? 'bg-sky-500' : 'hover:bg-slate-800' }}">
                Export Data
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 space-y-4">
            <div>
                <p class="text-xs text-slate-400 mb-2">Tanggal Hari Ini</p>
                <div class="bg-slate-900 border border-slate-700 rounded-lg px-3 py-3 text-sm">
                    📅 <span id="todayDateText"></span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-lg text-sm font-bold">
                    Logout
                </button>
            </form>

            <p class="text-xs text-slate-500 text-center">
                CNN-LSTM + FastText Model
            </p>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="flex-1 h-screen overflow-y-auto bg-slate-50">

        {{-- TOPBAR --}}
        <header class="h-[78px] bg-white border-b border-slate-200 px-8 flex items-center justify-between sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <div class="w-2 h-10 bg-sky-500 rounded-full"></div>
                <div>
                    <h1 class="font-bold text-xl text-slate-900">
                        Telkomsel Analytics Platform
                    </h1>
                    <p class="text-xs text-slate-500">
                        Customer Satisfaction Analysis System
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-bold text-sm text-slate-900">
                        {{ session('admin_name') ?? 'Admin Telkomsel' }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ session('admin_email') ?? 'admin@telkomsel.co.id' }}
                    </p>
                </div>

                <div class="w-11 h-11 rounded-full bg-sky-500 text-white flex items-center justify-center font-bold">
                    AT
                </div>
            </div>
        </header>

        <section>
            @yield('content')
        </section>

    </main>
</div>

<script>
function setTanggalHariIni() {
    const today = new Date();
    const bulan = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const target = document.getElementById('todayDateText');
    if (target) {
        target.innerText = `${today.getDate()} ${bulan[today.getMonth()]} ${today.getFullYear()}`;
    }
}

setTanggalHariIni();
</script>

</body>
</html>