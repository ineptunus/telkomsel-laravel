@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-50 min-h-screen">

    <div class="flex justify-between items-start mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Export Laporan</h1>
            <p class="text-slate-500 mt-2">
                Pilih template untuk menghasilkan laporan PDF terformat lengkap — bukan sekadar data mentah
            </p>
        </div>

        <div class="bg-white border rounded-xl px-5 py-3 text-sm text-slate-500">
            <span class="text-green-500">●</span> Data live — diperbarui setiap 5 menit
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <span class="text-sky-500">▽</span>
            Template Laporan
            <span class="text-sm font-normal text-slate-400">
                Klik untuk memilih — laporan PDF otomatis terisi
            </span>
        </h2>

        @php
            $templates = [
                [
                    'key' => 'kepuasan',
                    'title' => 'Laporan Kepuasan Mingguan',
                    'desc' => 'Ringkasan skor NPS, distribusi sentimen, analisis per kategori layanan, dan rekomendasi.',
                    'tag' => 'Populer',
                    'color' => 'green',
                    'icon' => '☆',
                    'records' => '2,500',
                    'page' => '~3 hal PDF'
                ],
                [
                    'key' => 'hate-sarcasm',
                    'title' => 'Data Hate Speech & Sarcasm',
                    'desc' => 'Tweet terdeteksi HS & sarcasm, confidence score, performa model CNN-LSTM, dan contoh kasus.',
                    'tag' => 'Analisis',
                    'color' => 'red',
                    'icon' => '♜',
                    'records' => '4,120',
                    'page' => '~3 hal PDF'
                ],
                [
                    'key' => 'sentimen-full',
                    'title' => 'Sentimen Analysis Full Data',
                    'desc' => 'Laporan lengkap distribusi sentimen, performa model, kategori layanan, dan top keywords.',
                    'tag' => 'Lengkap',
                    'color' => 'blue',
                    'icon' => '↗',
                    'records' => '12,450',
                    'page' => '~4 hal PDF'
                ],
                [
                    'key' => 'keywords',
                    'title' => 'Top Keywords & Tren',
                    'desc' => 'Kata kunci paling sering muncul, distribusi topik, dan tren keluhan pelanggan.',
                    'tag' => 'Keywords',
                    'color' => 'purple',
                    'icon' => '#',
                    'records' => '3,800',
                    'page' => '~2 hal PDF',
                    'active' => true
                ],
                [
                    'key' => 'bulanan',
                    'title' => 'Laporan Bulanan Eksekutif',
                    'desc' => 'Laporan eksekutif bulanan: KPI, perbandingan periode, analisis mendalam, dan rekomendasi strategis.',
                    'tag' => 'Eksekutif',
                    'color' => 'yellow',
                    'icon' => '▥',
                    'records' => '9,200',
                    'page' => '~4 hal PDF'
                ],
                [
                    'key' => 'sarcasm-detail',
                    'title' => 'Detail Tren Sarcasm',
                    'desc' => 'Analisis mendalam pola sarkasme: statistik, confidence score, keywords, dan contoh tweet.',
                    'tag' => 'Sarcasm',
                    'color' => 'orange',
                    'icon' => '▣',
                    'records' => '2,900',
                    'page' => '~3 hal PDF'
                ],
            ];

            function colorClass($color, $type) {
                $map = [
                    'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'pill' => 'bg-green-100 text-green-700'],
                    'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'pill' => 'bg-red-100 text-red-700'],
                    'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'pill' => 'bg-blue-100 text-blue-700'],
                    'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'pill' => 'bg-purple-100 text-purple-700'],
                    'yellow' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'pill' => 'bg-yellow-100 text-yellow-700'],
                    'orange' => ['bg' => 'bg-orange-50', 'text' => 'text-orange-600', 'pill' => 'bg-orange-100 text-orange-700'],
                ];
                return $map[$color][$type];
            }
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($templates as $template)
                <a href="{{ route('export.download.report', $template['key']) }}"
                   class="block bg-white rounded-2xl border p-6 relative hover:shadow-lg hover:-translate-y-1 transition
                   {{ isset($template['active']) ? 'border-sky-500 bg-sky-50/40 shadow-sm' : 'border-slate-200' }}">

                    <div class="flex justify-between items-start mb-8">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl {{ colorClass($template['color'], 'bg') }} {{ colorClass($template['color'], 'text') }}">
                            {{ $template['icon'] }}
                        </div>

                        <span class="text-xs font-bold px-3 py-1 rounded-full {{ colorClass($template['color'], 'pill') }}">
                            {{ $template['tag'] }}
                        </span>
                    </div>

                    <h3 class="font-bold text-slate-900 mb-2">{{ $template['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">{{ $template['desc'] }}</p>

                    <div class="border-t pt-4 flex gap-4 text-sm text-slate-400">
                        <span class="text-red-500 font-bold">▧ PDF</span>
                        <span># {{ $template['records'] }}</span>
                        <span>◷ {{ $template['page'] }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">

        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 p-7">
            <div class="flex justify-between mb-10">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <span class="text-sky-500">⇩</span>
                    Konfigurasi Laporan
                </h2>
                <span class="text-xs bg-sky-50 text-sky-600 px-3 py-1 rounded-full">
                    ⊙ Template dipilih
                </span>
            </div>

            <label class="font-bold text-sm">Periode Data</label>
            <select class="w-full bg-slate-100 rounded-lg px-4 py-3 mt-3 mb-8 font-semibold">
                <option>14 hari terakhir</option>
                <option>30 hari terakhir</option>
                <option>90 hari terakhir</option>
                <option>Semua data</option>
            </select>

            <div class="flex justify-between mb-4">
                <label class="font-bold text-sm">Kolom Data dalam Laporan</label>
            </div>

            @php
                $fields = [
                    ['Timestamp', false],
                    ['Username', false],
                    ['Konten Tweet', false],
                    ['Sentimen', false],
                    ['Hate Speech', false],
                    ['Sarcasm', false],
                    ['Confidence Score', false],
                    ['Kategori Layanan', false],
                    ['NPS Score', false],
                    ['Keywords', false],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-8">
                @foreach($fields as $field)
                <label class="border rounded-lg px-4 py-3 flex items-center gap-3
                    {{ $field[1] ? 'bg-sky-50 border-sky-400' : 'bg-white border-slate-200 text-slate-400' }}">
                    <input type="checkbox" {{ $field[1] ? 'checked' : '' }} class="rounded">
                    <span class="font-semibold text-sm">{{ $field[0] }}</span>
                </label>
                @endforeach
            </div>

            <div class="bg-green-50 border border-green-300 rounded-xl p-4 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-green-700">✓ Laporan siap dibuat!</h3>
                    <p class="text-sm text-green-600">Klik tombol untuk mengunduh laporan PDF terformat.</p>
                </div>

                <a href="{{ route('export.download.report', 'keywords') }}"
                   class="bg-sky-500 hover:bg-sky-600 text-white px-5 py-3 rounded-lg font-bold">
                    ⇩ Unduh Laporan
                </a>
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h2 class="font-bold mb-8">⊙ Preview Laporan</h2>

                <div class="bg-purple-50 rounded-xl p-4 mb-8">
                    <h3 class="font-bold text-purple-700"># Top Keywords & Tren</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Kata kunci paling sering muncul, distribusi topik, dan tren keluhan pelanggan.
                    </p>
                </div>

                <h3 class="text-sm tracking-wider text-slate-500 font-bold mb-3">ISI LAPORAN PDF</h3>
                <ul class="space-y-2 text-sm mb-8">
                    <li class="text-purple-600">⊙ Cover & identitas laporan</li>
                    <li class="text-purple-600">⊙ Top 10 keywords keluhan</li>
                    <li class="text-purple-600">⊙ Distribusi per topik layanan</li>
                </ul>

                <div class="border-t pt-5 space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Format</span>
                        <b>PDF (A4 Portrait)</b>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Periode</span>
                        <b>14 hari</b>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Estimasi halaman</span>
                        <b>2 halaman</b>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kolom data</span>
                        <b>4 field</b>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mt-6">
                    <span class="bg-sky-100 text-sky-600 px-3 py-1 rounded-full text-xs">Timestamp</span>
                    <span class="bg-sky-100 text-sky-600 px-3 py-1 rounded-full text-xs">Sentimen</span>
                    <span class="bg-sky-100 text-sky-600 px-3 py-1 rounded-full text-xs">Kategori Layanan</span>
                    <span class="bg-sky-100 text-sky-600 px-3 py-1 rounded-full text-xs">Keywords</span>
                </div>
            </div>

            <div class="bg-sky-500 text-white rounded-2xl p-7">
                <h2 class="font-bold text-lg mb-8">Data Tersedia</h2>

                <div class="grid grid-cols-2 gap-y-7">
                    <div>
                        <p class="text-sm opacity-90">Total Records</p>
                        <h3 class="text-2xl font-bold">{{ number_format($totalRecords ?? 12450) }}</h3>
                    </div>

                    <div>
                        <p class="text-sm opacity-90">Rentang Data</p>
                        <h3 class="text-2xl font-bold">90 hari</h3>
                    </div>

                    <div>
                        <p class="text-sm opacity-90">Total Ukuran</p>
                        <h3 class="text-2xl font-bold">2.4 MB</h3>
                    </div>

                    <div>
                        <p class="text-sm opacity-90">Last Update</p>
                        <h3 class="text-2xl font-bold">Live</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-7">
        <div class="flex justify-between mb-8">
            <h2 class="text-xl font-bold flex items-center gap-2">
                <span class="text-sky-500">▣</span>
                Riwayat Export
            </h2>
            <a href="#" class="text-sm text-slate-500">Lihat Semua ›</a>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500 tracking-wider border-b">
                    <th class="py-4">TANGGAL</th>
                    <th class="py-4">TEMPLATE LAPORAN</th>
                    <th class="py-4">FORMAT</th>
                    <th class="py-4">PERIODE</th>
                    <th class="py-4">RECORDS</th>
                    <th class="py-4">HALAMAN</th>
                    <th class="py-4">STATUS</th>
                    <th class="py-4"></th>
                </tr>
            </thead>

            <tbody>
                @php
                    $history = [
                        ['24 Jun 2026, 09:12', 'Laporan Kepuasan Mingguan', 'kepuasan', '7 hari', '2,500', '3 hal'],
                        ['20 Jun 2026, 14:30', 'Hate Speech & Sarcasm', 'hate-sarcasm', '30 hari', '4,120', '3 hal'],
                        ['15 Jun 2026, 10:15', 'Sentimen Full Data', 'sentimen-full', '90 hari', '12,450', '4 hal'],
                        ['10 Jun 2026, 16:45', 'Laporan Bulanan Eksekutif', 'bulanan', '30 hari', '9,200', '4 hal'],
                    ];
                @endphp

                @foreach($history as $item)
                <tr class="border-b">
                    <td class="py-4">{{ $item[0] }}</td>
                    <td class="py-4 font-semibold">{{ $item[1] }}</td>
                    <td class="py-4"><span class="bg-red-100 text-red-600 px-3 py-1 rounded-md text-xs font-bold">PDF</span></td>
                    <td class="py-4">{{ $item[3] }}</td>
                    <td class="py-4">{{ $item[4] }}</td>
                    <td class="py-4">{{ $item[5] }}</td>
                    <td class="py-4"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-md text-xs font-bold">⊙ Selesai</span></td>
                    <td class="py-4">
                        <a href="{{ route('export.download.report', $item[2]) }}" class="text-sky-500 font-bold">⇩</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection