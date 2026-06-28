<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 0; color: #111827; }
        .cover { background: #111820; color: white; height: 100vh; padding: 70px; border-left: 28px solid #1da1f2; }
        .brand { color: #1da1f2; font-size: 30px; font-weight: bold; letter-spacing: 6px; }
        .subtitle { color: #9ca3af; margin-top: 12px; }
        .line { height: 3px; background: #1da1f2; margin: 40px 0 120px; }
        .title { font-size: 38px; font-weight: bold; margin-bottom: 25px; }
        .desc { color: #cbd5e1; font-size: 15px; line-height: 1.7; }
        .meta { margin-top: 230px; display: table; width: 100%; border-spacing: 10px; }
        .meta-card { display: table-cell; background: #1f2937; padding: 16px; border-radius: 10px; }
        .meta-label { color: #1da1f2; font-size: 10px; font-weight: bold; }
        .page { padding: 55px; }
        h2 { border-left: 12px solid #1da1f2; padding-left: 18px; margin-bottom: 10px; }
        .small { color: #6b7280; margin-bottom: 25px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 35px; font-size: 12.5px; }
        th { background: #111820; color: white; text-align: left; padding: 12px; }
        td { border: 1px solid #e5e7eb; padding: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .grid { display: table; width: 100%; border-spacing: 12px; margin-bottom: 25px; }
        .card { display: table-cell; background: #f1f5f9; padding: 18px; border-radius: 12px; }
        .card b { font-size: 24px; color: #0ea5e9; }
        .alert { background: #fff7ed; border: 1px solid #fed7aa; padding: 15px; margin-bottom: 18px; border-radius: 10px; }
        .danger { background: #fef2f2; border: 1px solid #fecaca; }
        .green { background: #ecfdf5; border: 1px solid #bbf7d0; }
        .footer { position: fixed; bottom: 20px; left: 55px; right: 55px; font-size: 11px; color: #6b7280; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

<div class="cover">
    <div class="brand">Telkomsel</div>
    <div class="subtitle">Customer Satisfaction Analysis System</div>
    <div class="line"></div>

    <div class="title">{{ $title }}</div>

    <div class="desc">
        @if($template == 'kepuasan')
            Ringkasan mingguan tingkat kepuasan pelanggan, distribusi sentimen, indikator layanan, dan rekomendasi tindak lanjut.
        @elseif($template == 'hate-sarcasm')
            Laporan khusus untuk memantau tweet berisiko yang mengandung hate speech dan sarcasm pada interaksi pelanggan.
        @elseif($template == 'sentimen-full')
            Laporan lengkap hasil sentiment analysis pelanggan Telkomsel berdasarkan data tweet yang diproses sistem.
        @elseif($template == 'keywords')
            Kata kunci paling sering muncul, distribusi topik, dan tren keluhan pelanggan.
        @elseif($template == 'bulanan')
            Laporan eksekutif bulanan berisi KPI utama, risiko layanan, insight strategis, dan rekomendasi manajerial.
        @elseif($template == 'sarcasm-detail')
            Analisis mendalam pola sarkasme pelanggan, keyword sindiran, contoh tweet, dan confidence score.
        @else
            Laporan analisis pelanggan Telkomsel.
        @endif
    </div>

    <div class="meta">
        <div class="meta-card"><div class="meta-label">PERIODE</div><p>14 hari terakhir</p></div>
        <div class="meta-card"><div class="meta-label">FORMAT</div><p>PDF</p></div>
        <div class="meta-card"><div class="meta-label">TANGGAL</div><p>{{ date('d F Y') }}</p></div>
        <div class="meta-card"><div class="meta-label">STATUS</div><p>FINAL</p></div>
    </div>
</div>

<div class="page-break"></div>

<div class="page">

@if($template == 'kepuasan')

    <h2>Ringkasan Kepuasan Mingguan</h2>
    <p class="small">Laporan ini berfokus pada kondisi kepuasan pelanggan dalam periode mingguan.</p>

    <div class="grid">
        <div class="card">Total Data<br><b>{{ number_format($total) }}</b></div>
        <div class="card">Skor Kepuasan<br><b>{{ $total > 0 ? round(($positif / $total) * 100, 1) : 0 }}%</b></div>
        <div class="card">Sentimen Negatif<br><b>{{ $negatif }}</b></div>
    </div>

    <h2>Distribusi Sentimen</h2>
    <table>
        <tr><th>Kategori</th><th>Jumlah</th><th>Interpretasi</th></tr>
        <tr><td>Positif</td><td>{{ $positif }}</td><td>Pelanggan menunjukkan kepuasan terhadap layanan.</td></tr>
        <tr><td>Negatif</td><td>{{ $negatif }}</td><td>Keluhan yang perlu diprioritaskan oleh customer service.</td></tr>
        <tr><td>Netral</td><td>{{ $netral }}</td><td>Percakapan informatif tanpa emosi kuat.</td></tr>
    </table>

    <h2>Rekomendasi</h2>
    <div class="alert green">Pertahankan respons cepat pada keluhan jaringan dan pantau sentimen negatif harian.</div>

@elseif($template == 'hate-sarcasm')

    <h2>Ringkasan Risiko Konten</h2>
    <p class="small">Laporan ini memuat tweet yang perlu diprioritaskan karena mengandung hate speech atau sarcasm.</p>

    <div class="grid">
        <div class="card">Hate Speech<br><b>{{ $hate }}</b></div>
        <div class="card">Sarcasm<br><b>{{ $sarcasm }}</b></div>
        <div class="card">Tweet Prioritas<br><b>{{ $tweets->count() }}</b></div>
    </div>

    <h2>Tweet Prioritas</h2>
    <table>
        <tr><th>Username</th><th>Tweet</th><th>Sentimen</th><th>HS</th><th>Sarcasm</th></tr>
        @foreach($tweets as $tweet)
        <tr>
            <td>{{ $tweet->username_x }}</td>
            <td>{{ $tweet->tweet }}</td>
            <td>{{ $tweet->sentiment }}</td>
            <td>{{ $tweet->hate_speech }}</td>
            <td>{{ $tweet->sarcasm }}</td>
        </tr>
        @endforeach
    </table>

    <h2>Tindak Lanjut</h2>
    <div class="alert danger">Tweet hate speech perlu diprioritaskan untuk eskalasi atau moderasi.</div>
    <div class="alert">Tweet sarcasm menunjukkan ketidakpuasan tidak langsung dan perlu dianalisis sebagai sinyal reputasi.</div>

@elseif($template == 'sentimen-full')

    <h2>Sentiment Analysis Full Data</h2>
    <p class="small">Laporan lengkap distribusi sentimen pelanggan Telkomsel.</p>

    <table>
        <tr><th>Sentimen</th><th>Jumlah</th><th>Persentase</th></tr>
        <tr><td>Positif</td><td>{{ $positif }}</td><td>{{ $total > 0 ? round(($positif/$total)*100, 1) : 0 }}%</td></tr>
        <tr><td>Negatif</td><td>{{ $negatif }}</td><td>{{ $total > 0 ? round(($negatif/$total)*100, 1) : 0 }}%</td></tr>
        <tr><td>Netral</td><td>{{ $netral }}</td><td>{{ $total > 0 ? round(($netral/$total)*100, 1) : 0 }}%</td></tr>
    </table>

    <h2>Contoh Data Terbaru</h2>
    <table>
        <tr><th>Username</th><th>Tweet</th><th>Sentimen</th></tr>
        @foreach($tweets as $tweet)
        <tr><td>{{ $tweet->username_x }}</td><td>{{ $tweet->tweet }}</td><td>{{ $tweet->sentiment }}</td></tr>
        @endforeach
    </table>

@elseif($template == 'keywords')

    <h2>Top 10 Keywords Keluhan</h2>
    <p class="small">Kata kunci paling sering muncul periode 14 hari terakhir.</p>

    <table>
        <tr><th>Keyword</th><th>Frekuensi</th><th>Sentimen Dominan</th></tr>
        @foreach($keywords as $keyword)
        <tr><td>{{ $keyword[0] }}</td><td>{{ $keyword[1] }}</td><td>{{ $keyword[2] }}</td></tr>
        @endforeach
    </table>

    <h2>Distribusi per Topik</h2>
    <table>
        <tr><th>Kategori Layanan</th><th>Total Tweet</th><th>Skor Kepuasan</th><th>HS</th><th>Sarcasm</th></tr>
        @foreach($topics as $topic)
        <tr>
            <td>{{ $topic[0] }}</td>
            <td>{{ number_format($topic[1]) }}</td>
            <td>{{ $topic[2] }}</td>
            <td>{{ $topic[3] }}</td>
            <td>{{ $topic[4] }}</td>
        </tr>
        @endforeach
    </table>

@elseif($template == 'bulanan')

    <h2>Laporan Bulanan Eksekutif</h2>
    <p class="small">Ringkasan KPI utama untuk kebutuhan manajemen.</p>

    <div class="grid">
        <div class="card">Total Interaksi<br><b>{{ number_format($total) }}</b></div>
        <div class="card">Skor Kepuasan<br><b>{{ $total > 0 ? round(($positif/$total)*100, 1) : 0 }}%</b></div>
        <div class="card">Risk Content<br><b>{{ $hate + $sarcasm }}</b></div>
    </div>

    <h2>Insight Strategis</h2>
    <div class="alert">Keluhan dominan berkaitan dengan jaringan, kuota, dan aplikasi MyTelkomsel.</div>
    <div class="alert danger">Konten berisiko perlu dipantau karena dapat mempengaruhi reputasi layanan.</div>

    <h2>Rekomendasi Manajerial</h2>
    <table>
        <tr><th>Area</th><th>Rekomendasi</th><th>Prioritas</th></tr>
        <tr><td>Jaringan</td><td>Perkuat monitoring wilayah dengan keluhan sinyal tinggi.</td><td>Tinggi</td></tr>
        <tr><td>Customer Service</td><td>Prioritaskan respons tweet negatif dan sarcasm.</td><td>Tinggi</td></tr>
        <tr><td>Promo</td><td>Evaluasi komunikasi promo agar tidak memicu keluhan harga.</td><td>Sedang</td></tr>
    </table>

@elseif($template == 'sarcasm-detail')

    <h2>Detail Tren Sarcasm</h2>
    <p class="small">Laporan ini fokus pada pola sindiran pelanggan terhadap layanan Telkomsel.</p>

    <div class="grid">
        <div class="card">Total Sarcasm<br><b>{{ $sarcasm }}</b></div>
        <div class="card">Rasio Sarcasm<br><b>{{ $total > 0 ? round(($sarcasm/$total)*100, 1) : 0 }}%</b></div>
        <div class="card">Sentimen Negatif<br><b>{{ $negatif }}</b></div>
    </div>

    <h2>Pola Sarkasme Umum</h2>
    <table>
        <tr><th>Pola Kalimat</th><th>Makna</th><th>Contoh Konteks</th></tr>
        <tr><td>“Mantap banget...”</td><td>Sindiran terhadap layanan buruk</td><td>Sinyal lemot atau gangguan</td></tr>
        <tr><td>“Bagus sekali...”</td><td>Kritik tidak langsung</td><td>Internet lambat</td></tr>
        <tr><td>“Terima kasih Telkomsel...”</td><td>Keluhan berbentuk ironi</td><td>Kuota cepat habis</td></tr>
    </table>

    <h2>Contoh Tweet Sarcasm</h2>
    <table>
        <tr><th>Username</th><th>Tweet</th><th>Sentimen</th><th>Sarcasm</th></tr>
        @foreach($tweets as $tweet)
            @if($tweet->sarcasm == 'Ya')
            <tr>
                <td>{{ $tweet->username_x }}</td>
                <td>{{ $tweet->tweet }}</td>
                <td>{{ $tweet->sentiment }}</td>
                <td>{{ $tweet->sarcasm }}</td>
            </tr>
            @endif
        @endforeach
    </table>

@endif

</div>

<div class="footer">
    Telkomsel Customer Satisfaction Analysis — RAHASIA
</div>

</body>
</html>