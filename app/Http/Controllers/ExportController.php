<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function index()
    {
        $totalRecords = Tweet::count();

        return view('admin.export', compact('totalRecords'));
    }

    public function downloadReport($template)
    {
        $titles = [
            'kepuasan' => 'Laporan Kepuasan Mingguan',
            'hate-sarcasm' => 'Data Hate Speech & Sarcasm',
            'sentimen-full' => 'Sentimen Analysis Full Data',
            'keywords' => 'Top Keywords & Tren',
            'bulanan' => 'Laporan Bulanan Eksekutif',
            'sarcasm-detail' => 'Detail Tren Sarcasm',
        ];

        $title = $titles[$template] ?? 'Laporan Telkomsel Analytics';

        $total = Tweet::count();
        $positif = Tweet::where('sentiment', 'Positive')->count();
        $negatif = Tweet::where('sentiment', 'Negative')->count();
        $netral = Tweet::where('sentiment', 'Neutral')->count();
        $hate = Tweet::where('hate_speech', 'Ya')->count();
        $sarcasm = Tweet::where('sarcasm', 'Ya')->count();

        $tweets = Tweet::latest()->limit(10)->get();

        $keywords = [
            ['sinyal', 843, 'Negatif'],
            ['lemot', 712, 'Negatif'],
            ['CS', 654, 'Netral'],
            ['tagihan', 598, 'Negatif'],
            ['kuota', 534, 'Negatif'],
            ['promo', 487, 'Positif'],
            ['internet', 463, 'Netral'],
            ['error', 421, 'Negatif'],
            ['puas', 398, 'Positif'],
            ['lambat', 376, 'Negatif'],
        ];

        $topics = [
            ['Internet & Data', 3820, 68.2, 420, 382],
            ['Layanan Suara', 2140, 74.5, 198, 211],
            ['MyTelkomsel App', 2650, 65.1, 387, 503],
            ['Kartu & SIM', 1890, 70.8, 302, 256],
            ['Tagihan & Pembayaran', 1950, 71.2, 525, 752],
        ];

        $pdf = Pdf::loadView('admin.template-report', compact(
            'title',
            'template',
            'total',
            'positif',
            'negatif',
            'netral',
            'hate',
            'sarcasm',
            'tweets',
            'keywords',
            'topics'
        ))->setPaper('a4', 'portrait');

        return $pdf->download(str_replace(' ', '_', $title) . '_' . date('Y-m-d') . '.pdf');
    }
}