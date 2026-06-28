@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-50 min-h-screen">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-900">
            Statistik Kepuasan Pelanggan
        </h1>
        <p class="text-slate-600 mt-1">
            Statistik real berdasarkan data tweet yang masuk dari extension X.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <p class="text-slate-500 text-sm">Total Tweet</p>
            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalTweet) }}</h2>
            <p class="text-slate-500 text-sm mt-3">Data tersimpan di database</p>
        </div>

        <div class="bg-white rounded-2xl border border-green-300 p-6">
            <p class="text-slate-500 text-sm">Sentimen Positif</p>
            <h2 class="text-3xl font-bold mt-2 text-green-600">{{ $persenPositif }}%</h2>
            <p class="text-slate-500 text-sm mt-3">{{ number_format($positif) }} tweet</p>
        </div>

        <div class="bg-white rounded-2xl border border-red-300 p-6">
            <p class="text-slate-500 text-sm">Sentimen Negatif</p>
            <h2 class="text-3xl font-bold mt-2 text-red-600">{{ $persenNegatif }}%</h2>
            <p class="text-slate-500 text-sm mt-3">{{ number_format($negatif) }} tweet</p>
        </div>

        <div class="bg-white rounded-2xl border border-orange-300 p-6">
            <p class="text-slate-500 text-sm">Sarcasm</p>
            <h2 class="text-3xl font-bold mt-2 text-orange-500">{{ $persenSarcasm }}%</h2>
            <p class="text-slate-500 text-sm mt-3">{{ number_format($sarcasm) }} tweet</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-xl font-bold mb-6">Distribusi Sentimen Pelanggan</h2>
            <div style="height:330px;">
                <canvas id="sentimentChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-xl font-bold mb-6">Distribusi Risiko Konten</h2>
            <div style="height:330px;">
                <canvas id="riskChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-green-50 border border-green-300 rounded-2xl p-8 mb-6">
        <h2 class="text-2xl font-bold mb-6">
            🏅 Insights & Rekomendasi Kepuasan Pelanggan
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="bg-white border border-green-300 rounded-xl p-5">
                <h3 class="font-bold text-lg mb-3">✓ Sentimen Positif</h3>
                <p>{{ $insightPositive }}</p>
            </div>

            <div class="bg-white border border-red-300 rounded-xl p-5">
                <h3 class="font-bold text-lg mb-3">⚠ Sentimen Negatif</h3>
                <p>{{ $insightNegative }}</p>
            </div>

            <div class="bg-white border border-blue-300 rounded-xl p-5">
                <h3 class="font-bold text-lg mb-3">ℹ Hate Speech</h3>
                <p>{{ $insightHate }}</p>
            </div>

            <div class="bg-white border border-purple-300 rounded-xl p-5">
                <h3 class="font-bold text-lg mb-3">★ Sarcasm</h3>
                <p>{{ $insightSarcasm }}</p>
            </div>
        </div>
    </div>

</div>

<script>
new Chart(document.getElementById('sentimentChart'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($sentimentLabels) !!},
        datasets: [{
            data: {!! json_encode($sentimentData) !!},
            backgroundColor: ['#10b981', '#ef4444', '#64748b']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

new Chart(document.getElementById('riskChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($riskLabels) !!},
        datasets: [{
            label: 'Jumlah Tweet',
            data: {!! json_encode($riskData) !!},
            backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
            borderRadius: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection