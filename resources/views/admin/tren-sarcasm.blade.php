@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-50 min-h-screen">

    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Analisis Tren Sarcasm</h1>
            <p class="text-slate-600 mt-1">
                Monitoring deteksi sarcasm berdasarkan tweet pelanggan yang masuk ke sistem.
            </p>
        </div>

        <div class="bg-orange-500 text-white px-6 py-4 rounded-xl shadow">
            <p class="text-sm font-semibold">Total Sarcasm Terdeteksi</p>
            <h2 class="text-3xl font-bold">{{ number_format($totalSarcasm ?? 0) }}</h2>
            <p class="text-sm">{{ $persenSarcasm ?? 0 }}%</p>
        </div>
    </div>

    <div class="bg-orange-50 border-l-4 border-orange-500 rounded-xl p-5 mb-6">
        <h2 class="font-bold text-orange-700 text-lg">⚠ Peringatan Sarcasm</h2>
        <p class="text-orange-600 text-sm mt-1">
            Dari total {{ number_format($totalTweet ?? 0) }} tweet, terdeteksi
            {{ number_format($totalSarcasm ?? 0) }} tweet sarcasm
            atau sebesar {{ $persenSarcasm ?? 0 }}%.
        </p>
    </div>

    <div class="bg-white rounded-2xl border p-6 mb-6">
        <h2 class="text-xl font-bold mb-6">Tren Sarcasm Bulanan</h2>
        <div style="height:320px;">
            <canvas id="sarcasmTrendChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-xl font-bold mb-8">Distribusi Level Severity</h2>

            @php
                $levels = [
                    [
                        'label' => 'Rendah',
                        'value' => $rendah ?? 0,
                        'percent' => round((($rendah ?? 0) / ($totalSeverity ?? 1)) * 100, 1),
                        'color' => 'bg-yellow-400'
                    ],
                    [
                        'label' => 'Sedang',
                        'value' => $sedang ?? 0,
                        'percent' => round((($sedang ?? 0) / ($totalSeverity ?? 1)) * 100, 1),
                        'color' => 'bg-orange-400'
                    ],
                    [
                        'label' => 'Tinggi',
                        'value' => $tinggi ?? 0,
                        'percent' => round((($tinggi ?? 0) / ($totalSeverity ?? 1)) * 100, 1),
                        'color' => 'bg-orange-600'
                    ],
                    [
                        'label' => 'Sangat Tinggi',
                        'value' => $sangatTinggi ?? 0,
                        'percent' => round((($sangatTinggi ?? 0) / ($totalSeverity ?? 1)) * 100, 1),
                        'color' => 'bg-red-700'
                    ],
                ];
            @endphp

            <div class="space-y-6">
                @foreach($levels as $level)
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span>{{ $level['label'] }}</span>
                            <span class="text-orange-500">
                                {{ $level['value'] }} ({{ $level['percent'] }}%)
                            </span>
                        </div>

                        <div class="w-full bg-slate-200 rounded-full h-3">
                            <div class="{{ $level['color'] }} h-3 rounded-full"
                                 style="width: {{ $level['percent'] }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-xl font-bold mb-6">Keyword Dominan Sarcasm</h2>

            <div class="h-72 flex items-center justify-center relative text-orange-500 overflow-hidden">
                <span class="absolute text-6xl font-bold left-52 top-24">mantap</span>
                <span class="absolute text-5xl font-bold rotate-90 right-40 top-20">bagus</span>
                <span class="absolute text-5xl font-bold rotate-90 left-24 top-24">hebat</span>
                <span class="absolute text-4xl font-bold rotate-90 right-20 top-16">terbaik</span>
                <span class="absolute text-3xl font-bold left-32 top-14">keren</span>
                <span class="absolute text-3xl font-bold left-64 top-14 rotate-90">wow</span>
                <span class="absolute text-3xl font-bold right-72 top-32 rotate-90">puas</span>
                <span class="absolute text-2xl font-bold right-64 top-32">juara</span>
                <span class="absolute text-2xl font-bold left-96 top-40 rotate-90">sempurna</span>
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-xl font-bold mb-4">Contoh Tweet dengan Sarcasm</h2>

        <div class="bg-white rounded-xl border overflow-x-auto">
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
                    @forelse($tweetsSarcasm ?? [] as $tweet)
                        <tr class="border-b">
                            <td class="p-4">{{ $tweet->username_x }}</td>
                            <td class="p-4">{{ $tweet->tweet }}</td>
                            <td class="p-4">{{ $tweet->created_at }}</td>

                            <td class="p-4">
                                <span class="border px-3 py-1 rounded-full text-xs">
                                    {{ $tweet->hate_speech }}
                                </span>
                            </td>

                            <td class="p-4">
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">
                                    {{ $tweet->sarcasm }}
                                </span>
                            </td>

                            <td class="p-4">
                                @if($tweet->sentiment == 'Positive')
                                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">
                                        positive
                                    </span>
                                @elseif($tweet->sentiment == 'Negative')
                                    <span class="bg-pink-100 text-red-600 px-3 py-1 rounded-full text-xs">
                                        negative
                                    </span>
                                @else
                                    <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs">
                                        neutral
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400">
                                Belum ada data sarcasm.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
new Chart(document.getElementById('sarcasmTrendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($labels ?? []) !!},
        datasets: [{
            label: 'Total Sarcasm',
            data: {!! json_encode($sarcasmData ?? []) !!},
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245,158,11,0.35)',
            fill: true,
            tension: 0.4
        }]
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
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection