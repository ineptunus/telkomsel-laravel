@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-50 min-h-screen">

    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold">Statistik Kepuasan Pelanggan</h1>
            <p class="text-slate-600 mt-1">Analisis mendalam tingkat kepuasan pelanggan Telkomsel</p>
        </div>

        <div class="bg-green-600 text-white px-6 py-4 rounded-xl shadow">
            <p class="text-sm">Skor Kepuasan Saat Ini</p>
            <h2 class="text-3xl font-bold">{{ $skorKepuasan ?? 0 }}% <span class="text-sm">↗ +3.7%</span></h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-green-500 p-6">
            <p class="text-slate-500">Net Promoter Score</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $nps ?? 46 }}</h2>
            <p class="text-xs text-slate-500">Excellent</p>
        </div>

        <div class="bg-white rounded-2xl border border-blue-500 p-6">
            <p class="text-slate-500">Total Responden</p>
            <h2 class="text-3xl font-bold text-blue-600">{{ number_format($totalTweet ?? 0) }}</h2>
            <p class="text-xs text-slate-500">Bulan ini</p>
        </div>

        <div class="bg-white rounded-2xl border border-orange-500 p-6">
            <p class="text-slate-500">Avg Response Time</p>
            <h2 class="text-3xl font-bold text-orange-600">{{ $avgResponseTime ?? 42 }} min</h2>
            <p class="text-xs text-slate-500">-12% dari target</p>
        </div>

        <div class="bg-white rounded-2xl border border-purple-500 p-6">
            <p class="text-slate-500">Resolution Rate</p>
            <h2 class="text-3xl font-bold text-purple-600">{{ $resolutionRate ?? 85 }}%</h2>
            <p class="text-xs text-slate-500">First contact</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border p-6 mb-6">
        <h2 class="text-xl font-bold mb-6">Tren Skor Kepuasan Bulanan</h2>
        <canvas id="satisfactionTrend" height="90"></canvas>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-xl font-bold mb-6">Distribusi Sentimen Pelanggan</h2>
            <canvas id="sentimentChart" height="180"></canvas>

            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="bg-green-50 rounded-xl p-4 text-center">
                    <h3 class="text-2xl font-bold text-green-600">{{ $positif ?? 0 }}</h3>
                    <p class="text-sm">Positif</p>
                </div>
                <div class="bg-red-50 rounded-xl p-4 text-center">
                    <h3 class="text-2xl font-bold text-red-600">{{ $negatif ?? 0 }}</h3>
                    <p class="text-sm">Negatif</p>
                </div>
                <div class="bg-slate-100 rounded-xl p-4 text-center">
                    <h3 class="text-2xl font-bold text-slate-600">{{ $netral ?? 0 }}</h3>
                    <p class="text-sm">Netral</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-xl font-bold mb-8">Net Promoter Score (NPS) Breakdown</h2>

            @php
                $npsData = [
                    ['label' => 'Promoters (9-10)', 'value' => 58, 'count' => 1450, 'color' => 'bg-green-500'],
                    ['label' => 'Passives (7-8)', 'value' => 30, 'count' => 750, 'color' => 'bg-yellow-400'],
                    ['label' => 'Detractors (0-6)', 'value' => 12, 'count' => 300, 'color' => 'bg-red-500'],
                ];
            @endphp

            <div class="space-y-6">
                @foreach($npsData as $item)
                <div>
                    <div class="flex justify-between mb-2 text-sm">
                        <span>{{ $item['label'] }}</span>
                        <span>{{ $item['count'] }} ({{ $item['value'] }}%)</span>
                    </div>
                    <div class="w-full bg-slate-200 h-4 rounded-full">
                        <div class="{{ $item['color'] }} h-4 rounded-full text-white text-xs text-center"
                             style="width: {{ $item['value'] }}%">
                            {{ $item['value'] }}%
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 bg-green-50 border border-green-300 rounded-xl p-4 flex justify-between">
                <div>
                    <p class="text-sm text-slate-600">NPS Score</p>
                    <h2 class="text-3xl font-bold text-green-600">{{ $nps ?? 46 }}</h2>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-600">Kategori</p>
                    <h2 class="text-xl font-bold text-green-600">Excellent</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-xl font-bold mb-6">Kepuasan per Kategori Layanan</h2>
            <canvas id="serviceBar" height="180"></canvas>
        </div>

        <div class="bg-white rounded-2xl border p-6">
            <h2 class="text-xl font-bold mb-6">Faktor-faktor Kepuasan</h2>
            <canvas id="factorRadar" height="180"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border p-6 mb-6">
        <h2 class="text-xl font-bold mb-6">Performa Mingguan (April 2026)</h2>
        <canvas id="weeklyPerformance" height="90"></canvas>
    </div>

    <div class="bg-green-50 border border-green-300 rounded-2xl p-6">
        <h2 class="text-xl font-bold mb-6">🏅 Insights & Rekomendasi Kepuasan Pelanggan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border border-green-300 rounded-xl p-4">
                <b>✓ Tren Positif</b>
                <p class="text-sm mt-2">Skor kepuasan naik 3.7% dari bulan lalu menjadi {{ $skorKepuasan ?? 0 }}%.</p>
            </div>

            <div class="bg-white border border-yellow-300 rounded-xl p-4">
                <b>⚠ Area Perlu Perbaikan</b>
                <p class="text-sm mt-2">Kategori Harga Paket memiliki skor terendah. Perlu evaluasi strategi pricing.</p>
            </div>

            <div class="bg-white border border-blue-300 rounded-xl p-4">
                <b>ℹ Kinerja CS Meningkat</b>
                <p class="text-sm mt-2">Response time turun menjadi {{ $avgResponseTime ?? 42 }} menit.</p>
            </div>

            <div class="bg-white border border-purple-300 rounded-xl p-4">
                <b>★ Best Performer</b>
                <p class="text-sm mt-2">Customer Service mencapai skor 91%, melampaui target 90%.</p>
            </div>
        </div>
    </div>
</div>

<script>
new Chart(document.getElementById('satisfactionTrend'), {
    type: 'line',
    data: {
        labels: ['Okt 2025', 'Nov 2025', 'Des 2025', 'Jan 2026', 'Feb 2026', 'Mar 2026', 'Apr 2026'],
        datasets: [{
            label: 'Skor Kepuasan (%)',
            data: [76, 72, 79, 81, 78, 83, 86],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,0.35)',
            fill: true,
            tension: 0.4
        }]
    }
});

new Chart(document.getElementById('sentimentChart'), {
    type: 'pie',
    data: {
        labels: ['Positif', 'Negatif', 'Netral'],
        datasets: [{
            data: [{{ $positif ?? 0 }}, {{ $negatif ?? 0 }}, {{ $netral ?? 0 }}],
            backgroundColor: ['#10b981', '#ef4444', '#6b7280']
        }]
    }
});

new Chart(document.getElementById('serviceBar'), {
    type: 'bar',
    data: {
        labels: ['Kecepatan Internet', 'Harga Paket', 'Customer Service', 'Jangkauan Sinyal', 'Promo & Benefits', 'Aplikasi MyTelkomsel'],
        datasets: [
            {
                label: 'Skor Aktual',
                data: [88, 72, 91, 79, 85, 82],
                backgroundColor: '#10b981',
                borderRadius: 8
            },
            {
                label: 'Target',
                data: [85, 80, 90, 85, 80, 85],
                backgroundColor: '#d1d5db',
                borderRadius: 8
            }
        ]
    },
    options: { indexAxis: 'y' }
});

new Chart(document.getElementById('factorRadar'), {
    type: 'radar',
    data: {
        labels: ['Kualitas Layanan', 'Harga Kompetitif', 'Kecepatan Respon', 'Keandalan Jaringan', 'Kemudahan Akses', 'Fitur Inovatif'],
        datasets: [{
            label: 'Faktor Kepuasan',
            data: [86, 72, 78, 84, 82, 75],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16,185,129,0.35)'
        }]
    }
});

new Chart(document.getElementById('weeklyPerformance'), {
    type: 'line',
    data: {
        labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
        datasets: [
            {
                label: 'Kepuasan (%)',
                data: [83, 85, 84, 87],
                borderColor: '#10b981',
                backgroundColor: '#10b981',
                tension: 0.4
            },
            {
                label: 'Response Time (min)',
                data: [45, 42, 48, 38],
                borderColor: '#f59e0b',
                backgroundColor: '#f59e0b',
                tension: 0.4
            },
            {
                label: 'Resolved (%)',
                data: [78, 83, 81, 87],
                borderColor: '#3b82f6',
                backgroundColor: '#3b82f6',
                tension: 0.4
            }
        ]
    }
});
</script>
@endsection