<div class="w-64 min-h-screen bg-black text-white">

    <div class="p-6 border-b border-gray-800">

        <h1 class="text-xl font-bold text-blue-400">
            Telkomsel X
        </h1>

        <p class="text-sm text-gray-400">
            Analytics Platform
        </p>

    </div>

    <ul class="mt-6 px-3 space-y-2">

        <li>
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-lg
               {{ request()->routeIs('dashboard') ? 'bg-blue-500' : 'hover:bg-blue-500' }}">
               Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('statistik') }}"
               class="block px-4 py-3 rounded-lg
               {{ request()->routeIs('statistik') ? 'bg-blue-500' : 'hover:bg-blue-500' }}">
               Statistik Kepuasan
            </a>
        </li>

        <li>
            <a href="{{ route('tren.sarcasm') }}"
               class="block px-4 py-3 rounded-lg
               {{ request()->routeIs('tren.sarcasm') ? 'bg-blue-500' : 'hover:bg-blue-500' }}">
               Tren Sarcasm
            </a>
        </li>

        <li>
            <a href="{{ route('tren.hate') }}"
               class="block px-4 py-3 rounded-lg
               {{ request()->routeIs('tren.hate') ? 'bg-blue-500' : 'hover:bg-blue-500' }}">
               Tren Hate Speech
            </a>
        </li>

        <li>
            <a href="{{ route('export') }}"
               class="block px-4 py-3 rounded-lg
               {{ request()->routeIs('export') ? 'bg-blue-500' : 'hover:bg-blue-500' }}">
               Export Laporan
            </a>
        </li>

    </ul>

</div>