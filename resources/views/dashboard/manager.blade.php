<!DOCTYPE html>
<html>
<head>
    <title>Laporan Manajerial Telkomsel X Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-8 text-slate-900">

<div class="max-w-5xl mx-auto bg-white rounded-2xl shadow p-10">

    <div class="flex justify-between border-b pb-6 mb-8">
        <div>
            <h1 class="text-3xl font-bold">Laporan Manajerial</h1>
            <p class="text-slate-500">Telkomsel X Analytics — Customer Satisfaction Monitoring</p>
            <p class="text-sm text-slate-400 mt-2">Periode: {{ now()->format('d M Y') }}</p>
        </div>

        <button onclick="window.print()" class="bg-sky-500 text-white px-5 py-3 rounded-lg font-bold h-fit print:hidden">
            Print / Save PDF
        </button>
    </div>

    <h2 class="text-xl font-bold mb-4">1. Ringkasan Eksekutif</h2>

    <p class="leading-relaxed mb-6">
        Berdasarkan hasil monitoring tweet pelanggan pada platform X, sistem telah menganalisis
        <b>{{ number_format($total) }}</b> data. Skor kepuasan pelanggan saat ini berada pada angka
        <b>{{ $skorKepuasan }}%</b>. Terdapat <b>{{ $negatif }}</b> tweet bernada negatif,
        <b>{{ $hate }}</b> tweet terindikasi hate speech, dan <b>{{ $sarcasm }}</b> tweet terindikasi sarcasm.
    </p>

    <div class="grid grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-50 p-5 rounded-xl">
            <p class="text-sm text-slate-500">Total Data</p>
            <h3 class="text-3xl font-bold text-blue-600">{{ number_format($total) }}</h3>
        </div>

        <div class="bg-green-50 p-5 rounded-xl">
            <p class="text-sm text-slate-500">Skor Kepuasan</p>
            <h3 class="text-3xl font-bold text-green-600">{{ $skorKepuasan }}%</h3>
        </div>

        <div class="bg-red-50 p-5 rounded-xl">
            <p class="text-sm text-slate-500">Hate Speech</p>
            <h3 class="text-3xl font-bold text-red-600">{{ $hate }}</h3>
        </div>

        <div class="bg-orange-50 p-5 rounded-xl">
            <p class="text-sm text-slate-500">Sarcasm</p>
            <h3 class="text-3xl font-bold text-orange-600">{{ $sarcasm }}</h3>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-4">2. Analisis Sentimen</h2>

    <table class="w-full border mb-8">
        <thead class="bg-slate-100">
            <tr>
                <th class="border p-3 text-left">Kategori</th>
                <th class="border p-3 text-left">Jumlah</th>
                <th class="border p-3 text-left">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-3">Positif</td>
                <td class="border p-3">{{ $positif }}</td>
                <td class="border p-3">Menunjukkan kepuasan atau apresiasi pelanggan.</td>
            </tr>
            <tr>
                <td class="border p-3">Negatif</td>
                <td class="border p-3">{{ $negatif }} ({{ $persenNegatif }}%)</td>
                <td class="border p-3">Perlu dipantau karena berkaitan dengan keluhan layanan.</td>
            </tr>
            <tr>
                <td class="border p-3">Netral</td>
                <td class="border p-3">{{ $netral }}</td>
                <td class="border p-3">Berisi informasi umum atau percakapan tanpa emosi kuat.</td>
            </tr>
        </tbody>
    </table>

    <h2 class="text-xl font-bold mb-4">3. Temuan Risiko Konten</h2>

    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="border border-red-200 bg-red-50 rounded-xl p-5">
            <h3 class="font-bold text-red-700">Hate Speech</h3>
            <p class="mt-2">
                Terdapat <b>{{ $hate }}</b> tweet atau <b>{{ $persenHate }}%</b> dari total data
                yang terindikasi mengandung ujaran kasar atau menyerang.
            </p>
        </div>

        <div class="border border-orange-200 bg-orange-50 rounded-xl p-5">
            <h3 class="font-bold text-orange-700">Sarcasm</h3>
            <p class="mt-2">
                Terdapat <b>{{ $sarcasm }}</b> tweet atau <b>{{ $persenSarcasm }}%</b> dari total data
                yang mengandung sindiran terhadap layanan.
            </p>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-4">4. Rekomendasi Tindak Lanjut</h2>

    <ul class="list-disc ml-6 space-y-2 mb-8">
        <li>Prioritaskan respons terhadap tweet negatif dengan confidence tinggi.</li>
        <li>Keluhan terkait jaringan dan sinyal perlu dipantau sebagai isu utama.</li>
        <li>Tweet yang mengandung hate speech perlu diteruskan ke tim moderasi atau customer handling khusus.</li>
        <li>Tweet sarcasm dapat digunakan sebagai indikator ketidakpuasan tidak langsung pelanggan.</li>
        <li>Dashboard perlu dipantau harian untuk melihat perubahan tren sentimen pelanggan.</li>
    </ul>

    <h2 class="text-xl font-bold mb-4">5. Tweet Prioritas</h2>

    <table class="w-full border text-sm">
        <thead class="bg-slate-100">
            <tr>
                <th class="border p-3 text-left">Username</th>
                <th class="border p-3 text-left">Tweet</th>
                <th class="border p-3">Sentimen</th>
                <th class="border p-3">Hate</th>
                <th class="border p-3">Sarcasm</th>
            </tr>
        </thead>
        <tbody>
            @forelse($priorityTweets as $tweet)
            <tr>
                <td class="border p-3">{{ $tweet->username_x }}</td>
                <td class="border p-3">{{ $tweet->tweet }}</td>
                <td class="border p-3 text-center">{{ $tweet->sentiment }}</td>
                <td class="border p-3 text-center">{{ $tweet->hate_speech }}</td>
                <td class="border p-3 text-center">{{ $tweet->sarcasm }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="border p-4 text-center text-slate-400">
                    Belum ada tweet prioritas.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-10 pt-6 border-t text-sm text-slate-500">
        Laporan ini dibuat otomatis oleh Telkomsel X Analytics menggunakan model CNN-LSTM + FastText.
    </div>
</div>

</body>
</html>