@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-50 min-h-screen">

    {{-- HEADER --}}
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Dashboard Analisis Kepuasan Pelanggan
            </h1>
            <p class="text-slate-600 mt-1">
                Monitoring sentimen pelanggan Telkomsel di platform X (Twitter)
            </p>
        </div>

        <div class="bg-sky-500 text-white px-6 py-4 rounded-xl shadow">
            <p class="text-sm font-semibold">Last Updated</p>
            <h3 class="font-bold">
                <span id="lastUpdated"></span>
            </h3>
        </div>
    </div>

    {{-- CARD SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-sky-500 p-6 shadow-sm">
            <div class="flex justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Total Data Teranalisis</p>
                    <h2 class="text-3xl font-bold mt-2">{{ number_format($totalTweet ?? 0) }}</h2>
                    <p class="text-green-600 text-sm mt-3">↑ 12.5% dari minggu lalu</p>
                </div>
                <div class="bg-sky-100 text-sky-500 w-12 h-12 rounded-xl flex items-center justify-center text-2xl">
                    ▣
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-emerald-500 p-6 shadow-sm">
            <div class="flex justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Skor Kepuasan</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $skorKepuasan ?? 0 }}%</h2>
                    <p class="text-green-600 text-sm mt-3">↑ 5.2% dari minggu lalu</p>
                </div>
                <div class="bg-emerald-100 text-emerald-500 w-12 h-12 rounded-xl flex items-center justify-center text-2xl">
                    ☺
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-red-500 p-6 shadow-sm">
            <div class="flex justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Total Hate Speech</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $hate ?? 0 }}</h2>
                    <p class="text-red-600 text-sm mt-3">↓ 8.3% dari minggu lalu</p>
                </div>
                <div class="bg-red-100 text-red-500 w-12 h-12 rounded-xl flex items-center justify-center text-2xl">
                    ⚠
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-orange-500 p-6 shadow-sm">
            <div class="flex justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Total Sarcasm</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $sarcasm ?? 0 }}</h2>
                    <p class="text-red-600 text-sm mt-3">↓ 3.1% dari minggu lalu</p>
                </div>
                <div class="bg-orange-100 text-orange-500 w-12 h-12 rounded-xl flex items-center justify-center text-2xl">
                    ▱
                </div>
            </div>
        </div>

    </div>

    {{-- TREND CHART --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
        <h2 class="text-xl font-bold mb-6">Tren Mingguan</h2>
        <div style="height:320px;">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    {{-- WORD CLOUD + PIE --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-xl font-bold mb-6">Sarcasm Keywords</h2>

            <div class="h-80 relative overflow-hidden">
                <span class="absolute text-6xl font-bold text-sky-500 left-44 top-32">paket</span>
                <span class="absolute text-5xl font-bold text-black left-96 top-32">sinyal</span>
                <span class="absolute text-4xl font-bold text-slate-400 left-20 top-32 rotate-90">lemot</span>
                <span class="absolute text-4xl font-bold text-black right-32 top-28 rotate-90">internet</span>
                <span class="absolute text-4xl font-bold text-slate-400 right-44 top-20 rotate-90">mahal</span>
                <span class="absolute text-3xl font-bold text-sky-500 right-20 top-24 rotate-90">gangguan</span>
                <span class="absolute text-3xl font-bold text-slate-400 left-72 top-44 rotate-90">jaringan</span>
                <span class="absolute text-3xl font-bold text-slate-500 right-56 top-44 rotate-90">kuota</span>
                <span class="absolute text-2xl font-bold text-slate-400 left-80 top-28">hilang</span>
                <span class="absolute text-2xl font-bold text-slate-500 left-96 top-48 rotate-90">pulsa</span>
                <span class="absolute text-xl font-bold text-sky-500 left-60 top-28">error</span>
                <span class="absolute text-xl font-bold text-black left-56 top-14">promo</span>
                <span class="absolute text-xl font-bold text-slate-300 left-52 top-8">lambat</span>
                <span class="absolute text-lg font-bold text-sky-500 right-40 top-24 rotate-90">habis</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-xl font-bold mb-6">Distribusi Sentimen</h2>
            <div class="h-80 flex justify-center items-center">
                <canvas id="sentimentPie"></canvas>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <h2 class="text-xl font-bold mb-4">Keluhan Pelanggan Terbaru</h2>

    <div class="bg-white rounded-xl border border-slate-200 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b">
                <tr class="text-left">
                    <th class="p-4">Username</th>
                    <th class="p-4">Tweet</th>
                    <th class="p-4">Waktu</th>
                    <th class="p-4">Hate Speech</th>
                    <th class="p-4">Sarcasm</th>
                    <th class="p-4">Sentimen</th>
                </tr>
            </thead>

            <tbody>
                @forelse($tweets ?? [] as $tweet)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-4 font-semibold">{{ $tweet->username_x }}</td>
                        <td class="p-4">{{ $tweet->tweet }}</td>
                        <td class="p-4 text-slate-500">{{ $tweet->created_at }}</td>

                        <td class="p-4">
                            @if($tweet->hate_speech == 'Ya')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold">Ya</span>
                            @else
                                <span class="border px-3 py-1 rounded-full text-xs">Tidak</span>
                            @endif
                        </td>

                        <td class="p-4">
                            @if($tweet->sarcasm == 'Ya')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-bold">Ya</span>
                            @else
                                <span class="border px-3 py-1 rounded-full text-xs">Tidak</span>
                            @endif
                        </td>

                        <td class="p-4">
                            @if($tweet->sentiment == 'Positive')
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">positive</span>
                            @elseif($tweet->sentiment == 'Negative')
                                <span class="bg-pink-100 text-red-600 px-3 py-1 rounded-full text-xs">negative</span>
                            @else
                                <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs">neutral</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-400">
                            Belum ada data keluhan pelanggan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
new Chart(document.getElementById('weeklyChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($trendLabels) !!},
        datasets: [
            {
                label: 'Skor Kepuasan (%)',
                data: {!! json_encode($kepuasanData) !!},
                borderColor: '#10b981',
                backgroundColor: '#10b981',
                tension: 0.4
            },
            {
                label: 'Hate Speech',
                data: {!! json_encode($hateData) !!},
                borderColor: '#ef4444',
                backgroundColor: '#ef4444',
                tension: 0.4
            },
            {
                label: 'Sarcasm',
                data: {!! json_encode($sarcasmData) !!},
                borderColor: '#f59e0b',
                backgroundColor: '#f59e0b',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

new Chart(document.getElementById('sentimentPie'), {
    type: 'pie',
    data: {
        labels: ['Positif', 'Negatif', 'Netral'],
        datasets: [{
            data: [
                {{ $positif ?? 0 }},
                {{ $negatif ?? 0 }},
                {{ $netral ?? 0 }}
            ],
            backgroundColor: ['#10b981', '#ef4444', '#6b7280']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function updateLastUpdated() {
    const now = new Date();

    const options = {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };

    document.getElementById('lastUpdated').innerHTML =
        now.toLocaleString('id-ID', options);
}

updateLastUpdated();
setInterval(updateLastUpdated, 1000);
</script>
@endsection