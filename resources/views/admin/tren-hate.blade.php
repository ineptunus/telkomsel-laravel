@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-50 min-h-screen">

    <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-5 mb-6">
        <h2 class="font-bold text-red-700 text-lg">⚠ Peringatan Moderasi Konten</h2>
        <p class="text-red-600 text-sm mt-1">
            Dari total {{ number_format($totalTweet ?? 0) }} tweet, terdeteksi
            {{ number_format($totalHate ?? 0) }} tweet hate speech
            atau sebesar {{ $persenHate ?? 0 }}%.
        </p>
    </div>

    <div class="bg-white rounded-2xl border p-6 mb-6">
        <h2 class="text-xl font-bold mb-6">Tren Hate Speech Bulanan</h2>
        <div style="height:320px;">
            <canvas id="hateTrendChart"></canvas>
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
                        'color' => 'bg-red-500'
                    ],
                    [
                        'label' => 'Sangat Tinggi',
                        'value' => $sangatTinggi ?? 0,
                        'percent' => round((($sangatTinggi ?? 0) / ($totalSeverity ?? 1)) * 100, 1),
                        'color' => 'bg-red-900'
                    ],
                ];
            @endphp

            <div class="space-y-6">
                @foreach($levels as $level)
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span>{{ $level['label'] }}</span>
                            <span class="text-red-500">
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
            <h2 class="text-xl font-bold mb-6">Keyword Dominan Hate Speech</h2>

            <div class="h-72 flex items-center justify-center relative text-red-600 overflow-hidden">
                <span class="absolute text-6xl font-bold left-52 top-24">sampah</span>
                <span class="absolute text-5xl font-bold rotate-90 right-40 top-20">bodoh</span>
                <span class="absolute text-5xl font-bold rotate-90 left-24 top-24">goblok</span>
                <span class="absolute text-4xl font-bold rotate-90 right-20 top-16">bangsat</span>
                <span class="absolute text-3xl font-bold left-32 top-14">payah</span>
                <span class="absolute text-3xl font-bold left-64 top-14 rotate-90">anjing</span>
                <span class="absolute text-3xl font-bold right-72 top-32 rotate-90">tolol</span>
                <span class="absolute text-2xl font-bold right-64 top-32">tai</span>
                <span class="absolute text-2xl font-bold left-96 top-40 rotate-90">jelek</span>
                <span class="absolute text-xl font-bold right-80 top-14">buruk</span>
                <span class="absolute text-xl font-bold left-40 top-36">rusak</span>
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-xl font-bold mb-4">Contoh Tweet dengan Hate Speech</h2>

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
                    @forelse($tweetsHate ?? [] as $tweet)
                        <tr class="border-b">
                            <td class="p-4">{{ $tweet->username_x }}</td>
                            <td class="p-4">{{ $tweet->tweet }}</td>
                            <td class="p-4">{{ $tweet->created_at }}</td>

                            <td class="p-4">
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                                    {{ $tweet->hate_speech }}
                                </span>
                            </td>

                            <td class="p-4">
                                <span class="border px-3 py-1 rounded-full text-xs">
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
                                Belum ada data hate speech.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
new Chart(document.getElementById('hateTrendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($labels ?? []) !!},
        datasets: [{
            label: 'Total Hate Speech',
            data: {!! json_encode($hateData ?? []) !!},
            borderColor: '#ef4444',
            backgroundColor: 'rgba(239,68,68,0.35)',
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