@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-100 min-h-screen">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Export Data</h1>
        <p class="text-slate-500 mt-1">
            Ekspor data analisis untuk keperluan laporan dan analisis lanjutan
        </p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

        {{-- KONFIGURASI EXPORT --}}
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h2 class="text-xl font-bold mb-8 flex items-center gap-2">
                <span class="text-sky-500">⬇</span> Konfigurasi Export
            </h2>

            <form action="#" method="GET">

                <label class="block font-semibold mb-3">Format File</label>
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <label class="cursor-pointer">
                        <input type="radio" name="format" value="csv" class="hidden peer" checked>
                        <div class="peer-checked:bg-sky-500 peer-checked:text-white border rounded-lg py-3 text-center font-semibold">
                            CSV
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="format" value="excel" class="hidden peer">
                        <div class="peer-checked:bg-sky-500 peer-checked:text-white border rounded-lg py-3 text-center font-semibold">
                            Excel
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="format" value="json" class="hidden peer">
                        <div class="peer-checked:bg-sky-500 peer-checked:text-white border rounded-lg py-3 text-center font-semibold">
                            JSON
                        </div>
                    </label>
                </div>

                <label class="block font-semibold mb-3">Periode Data</label>
                <select class="w-full bg-slate-100 border rounded-lg p-3 mb-6">
                    <option>7 hari terakhir</option>
                    <option>14 hari terakhir</option>
                    <option>30 hari terakhir</option>
                    <option>90 hari terakhir</option>
                    <option>Semua data</option>
                </select>

                <label class="block font-semibold mb-3">Pilih Field</label>
                <div class="space-y-2 mb-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Timestamp
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Username
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Tweet
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Sentiment
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Hate Speech
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Sarcasm
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" checked>
                        Confidence
                    </label>
                </div>

                <button class="w-full bg-sky-500 hover:bg-sky-600 text-white py-3 rounded-lg font-bold">
                    ⬇ Export Data
                </button>
            </form>
        </div>

        {{-- TEMPLATE + DATA AVAILABLE --}}
        <div class="space-y-6">

            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                    <span class="text-sky-500">⚱</span> Template Cepat
                </h2>

                <div class="space-y-3">
                    <div class="border rounded-lg p-3 flex items-center gap-3">
                        <span class="text-green-500">▣</span>
                        <span class="font-semibold">Laporan Kepuasan Mingguan</span>
                    </div>

                    <div class="border rounded-lg p-3 flex items-center gap-3">
                        <span class="text-red-500">▣</span>
                        <span class="font-semibold">Data Hate Speech & Sarcasm</span>
                    </div>

                    <div class="border rounded-lg p-3 flex items-center gap-3">
                        <span class="text-blue-500">▣</span>
                        <span class="font-semibold">Sentimen Analysis Full Data</span>
                    </div>

                    <div class="border rounded-lg p-3 flex items-center gap-3">
                        <span class="text-purple-500">▣</span>
                        <span class="font-semibold">Top Keywords & Trends</span>
                    </div>
                </div>
            </div>

            <div class="bg-sky-500 text-white rounded-2xl shadow-sm p-6">
                <h2 class="text-xl font-bold mb-8">Data Available</h2>

                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <p class="text-sm opacity-90">Total Records</p>
                        <h3 class="text-3xl font-bold">{{ $totalRecords ?? '12,450' }}</h3>
                    </div>

                    <div>
                        <p class="text-sm opacity-90">Date Range</p>
                        <h3 class="text-xl font-bold">90 hari</h3>
                    </div>

                    <div>
                        <p class="text-sm opacity-90">Total Size</p>
                        <h3 class="text-xl font-bold">2.4 MB</h3>
                    </div>

                    <div>
                        <p class="text-sm opacity-90">Last Update</p>
                        <h3 class="text-xl font-bold">Live</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 rounded-2xl shadow-sm border">
            <p class="text-slate-500">Positif</p>
            <h2 class="text-3xl font-bold text-green-600">{{ $positif ?? 0 }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border">
            <p class="text-slate-500">Negatif</p>
            <h2 class="text-3xl font-bold text-red-600">{{ $negatif ?? 0 }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border">
            <p class="text-slate-500">Hate Speech</p>
            <h2 class="text-3xl font-bold text-rose-600">{{ $hate ?? 0 }}</h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border">
            <p class="text-slate-500">Sarcasm</p>
            <h2 class="text-3xl font-bold text-orange-500">{{ $sarcasm ?? 0 }}</h2>
        </div>
    </div>

    {{-- RIWAYAT EXPORT --}}
    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <h2 class="text-xl font-bold mb-8 flex items-center gap-2">
            <span class="text-sky-500">▣</span> Riwayat Export
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Format</th>
                        <th class="p-4">Periode</th>
                        <th class="p-4">Records</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-b">
                        <td class="p-4">15 Apr 2026, 14:30</td>
                        <td class="p-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded">CSV</span>
                        </td>
                        <td class="p-4">7 hari terakhir</td>
                        <td class="p-4">2,500</td>
                        <td class="p-4">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded">Selesai</span>
                        </td>
                        <td class="p-4 text-sky-500">⬇</td>
                    </tr>

                    <tr class="border-b">
                        <td class="p-4">12 Apr 2026, 10:15</td>
                        <td class="p-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded">Excel</span>
                        </td>
                        <td class="p-4">30 hari terakhir</td>
                        <td class="p-4">8,750</td>
                        <td class="p-4">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded">Selesai</span>
                        </td>
                        <td class="p-4 text-sky-500">⬇</td>
                    </tr>

                    <tr>
                        <td class="p-4">08 Apr 2026, 16:45</td>
                        <td class="p-4">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded">JSON</span>
                        </td>
                        <td class="p-4">14 hari terakhir</td>
                        <td class="p-4">5,200</td>
                        <td class="p-4">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded">Selesai</span>
                        </td>
                        <td class="p-4 text-sky-500">⬇</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
 
   <a href="{{ route('export.report') }}" target="_blank"
   class="w-full bg-sky-500 hover:bg-sky-600 text-white py-3 rounded-lg font-bold flex items-center justify-center gap-2">
    Generate Laporan Manajerial
</a>
</div>
@endsection