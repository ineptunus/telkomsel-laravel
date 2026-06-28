<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class SarcasmController extends Controller
{
    public function index()
    {
        $totalTweet = Tweet::count();
        $totalSarcasm = Tweet::where('sarcasm', 'Ya')->count();

        $persenSarcasm = $totalTweet > 0
            ? round(($totalSarcasm / $totalTweet) * 100, 2)
            : 0;

        $monthlySarcasm = Tweet::selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, COUNT(*) as total")
            ->where('sarcasm', 'Ya')
            ->groupBy('month')
            ->orderByRaw("MIN(created_at)")
            ->get();

        $labels = $monthlySarcasm->pluck('month');
        $sarcasmData = $monthlySarcasm->pluck('total');

        $rendah = Tweet::where('sarcasm', 'Ya')
            ->where('confidence_score', '<', 60)
            ->count();

        $sedang = Tweet::where('sarcasm', 'Ya')
            ->whereBetween('confidence_score', [60, 79])
            ->count();

        $tinggi = Tweet::where('sarcasm', 'Ya')
            ->whereBetween('confidence_score', [80, 89])
            ->count();

        $sangatTinggi = Tweet::where('sarcasm', 'Ya')
            ->where('confidence_score', '>=', 90)
            ->count();

        $totalSeverity = max(1, $rendah + $sedang + $tinggi + $sangatTinggi);

        $tweetsSarcasm = Tweet::where('sarcasm', 'Ya')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.tren-sarcasm', compact(
            'totalTweet',
            'totalSarcasm',
            'persenSarcasm',
            'labels',
            'sarcasmData',
            'rendah',
            'sedang',
            'tinggi',
            'sangatTinggi',
            'totalSeverity',
            'tweetsSarcasm'
        ));
    }
}