<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class HateSpeechController extends Controller
{
    public function index()
    {
        $totalTweet = Tweet::count();

        $totalHate = Tweet::where('hate_speech', 'Ya')->count();

        $persenHate = $totalTweet > 0
            ? round(($totalHate / $totalTweet) * 100, 2)
            : 0;

        $monthlyHate = Tweet::selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, COUNT(*) as total")
            ->where('hate_speech', 'Ya')
            ->groupBy('month')
            ->orderByRaw("MIN(created_at)")
            ->get();

        $labels = $monthlyHate->pluck('month');
        $hateData = $monthlyHate->pluck('total');

        $rendah = Tweet::where('hate_speech', 'Ya')
            ->where('confidence_score', '<', 60)
            ->count();

        $sedang = Tweet::where('hate_speech', 'Ya')
            ->whereBetween('confidence_score', [60, 79])
            ->count();

        $tinggi = Tweet::where('hate_speech', 'Ya')
            ->whereBetween('confidence_score', [80, 89])
            ->count();

        $sangatTinggi = Tweet::where('hate_speech', 'Ya')
            ->where('confidence_score', '>=', 90)
            ->count();

        $totalSeverity = max(1, $rendah + $sedang + $tinggi + $sangatTinggi);

        $tweetsHate = Tweet::where('hate_speech', 'Ya')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.tren-hate', compact(
            'totalTweet',
            'totalHate',
            'persenHate',
            'labels',
            'hateData',
            'rendah',
            'sedang',
            'tinggi',
            'sangatTinggi',
            'totalSeverity',
            'tweetsHate'
        ));
    }
}