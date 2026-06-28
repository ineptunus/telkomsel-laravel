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

        $hate = Tweet::where('hate_speech', 'Ya')->count();
        $sarcasm = Tweet::where('sarcasm', 'Ya')->count();

        $persenPositif = $totalTweet > 0 ? round(($positif / $totalTweet) * 100, 1) : 0;
        $persenNegatif = $totalTweet > 0 ? round(($negatif / $totalTweet) * 100, 1) : 0;
        $persenNetral  = $totalTweet > 0 ? round(($netral / $totalTweet) * 100, 1) : 0;
        $persenHate    = $totalTweet > 0 ? round(($hate / $totalTweet) * 100, 1) : 0;
        $persenSarcasm = $totalTweet > 0 ? round(($sarcasm / $totalTweet) * 100, 1) : 0;

        $skorKepuasan = $persenPositif;

        $sentimentLabels = ['Positif', 'Negatif', 'Netral'];
        $sentimentData = [$positif, $negatif, $netral];

        $riskLabels = ['Hate Speech', 'Sarcasm', 'Normal'];
        $riskData = [
            $hate,
            $sarcasm,
            max(0, $totalTweet - $hate - $sarcasm)
        ];

        $insightPositive = "Terdapat {$persenPositif}% tweet positif dari total {$totalTweet} tweet yang dianalisis.";
        $insightNegative = "Sebanyak {$persenNegatif}% tweet memiliki sentimen negatif dan perlu menjadi perhatian.";
        $insightHate = "Terdapat {$hate} tweet hate speech atau {$persenHate}% dari total data.";
        $insightSarcasm = "Sebanyak {$sarcasm} tweet terdeteksi sarcasm atau {$persenSarcasm}% dari total data.";

        return view('dashboard.statistik', compact(
            'totalTweet',
            'positif',
            'negatif',
            'netral',
            'hate',
            'sarcasm',
            'persenPositif',
            'persenNegatif',
            'persenNetral',
            'persenHate',
            'persenSarcasm',
            'skorKepuasan',
            'sentimentLabels',
            'sentimentData',
            'riskLabels',
            'riskData',
            'insightPositive',
            'insightNegative',
            'insightHate',
            'insightSarcasm'
        ));
    }
}