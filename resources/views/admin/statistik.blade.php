<?php

namespace App\Http\Controllers;

use App\Models\Tweet;

class StatistikController extends Controller
{
    public function index()
    {
        $totalTweet = Tweet::count();

        $positif = Tweet::where('sentiment', 'Positive')->count();
        $negatif = Tweet::where('sentiment', 'Negative')->count();
        $netral  = Tweet::where('sentiment', 'Neutral')->count();

        $skorKepuasan = $totalTweet > 0
            ? round(($positif / $totalTweet) * 100, 1)
            : 0;

        $nps = 46;
        $avgResponseTime = 42;
        $resolutionRate = 85;

        return view('dashboard.statistik', compact(
            'totalTweet',
            'positif',
            'negatif',
            'netral',
            'skorKepuasan',
            'nps',
            'avgResponseTime',
            'resolutionRate'
        ));
    }

    
}