<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalTweet = Tweet::count();

        $positif = Tweet::where('sentiment', 'Positive')->count();
        $negatif = Tweet::where('sentiment', 'Negative')->count();
        $netral  = Tweet::where('sentiment', 'Neutral')->count();

        $hate = Tweet::where('hate_speech', 'Ya')->count();
        $sarcasm = Tweet::where('sarcasm', 'Ya')->count();

        $skorKepuasan = $totalTweet > 0
            ? round(($positif / $totalTweet) * 100, 1)
            : 0;

        $tweets = Tweet::latest()->limit(5)->get();

        // TREND REAL PER HARI
        $dailyTrend = Tweet::selectRaw("
                DATE(created_at) as tanggal,
                COUNT(*) as total,
                SUM(CASE WHEN sentiment = 'Positive' THEN 1 ELSE 0 END) as positif,
                SUM(CASE WHEN hate_speech = 'Ya' THEN 1 ELSE 0 END) as hate,
                SUM(CASE WHEN sarcasm = 'Ya' THEN 1 ELSE 0 END) as sarcasm
            ")
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->limit(7)
            ->get();

        $trendLabels = $dailyTrend->pluck('tanggal')->map(function ($date) {
            return date('d M', strtotime($date));
        });

        $kepuasanData = $dailyTrend->map(function ($item) {
            return $item->total > 0
                ? round(($item->positif / $item->total) * 100, 1)
                : 0;
        });

        $hateData = $dailyTrend->pluck('hate');
        $sarcasmData = $dailyTrend->pluck('sarcasm');

        // KALAU DATA HARIAN MASIH KOSONG
        if ($trendLabels->isEmpty()) {
            $trendLabels = collect(['Belum ada data']);
            $kepuasanData = collect([0]);
            $hateData = collect([0]);
            $sarcasmData = collect([0]);
        }

        return view('dashboard.index', compact(
            'totalTweet',
            'positif',
            'negatif',
            'netral',
            'hate',
            'sarcasm',
            'skorKepuasan',
            'tweets',
            'trendLabels',
            'kepuasanData',
            'hateData',
            'sarcasmData'
        ));
    }
}