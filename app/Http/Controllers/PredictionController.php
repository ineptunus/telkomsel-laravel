<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Tweet;

class PredictionController extends Controller
{
    public function predict(Request $request)
    {
        try {
            $request->validate([
                'text' => 'required|string'
            ]);

         $response = Http::timeout(60)->post('https://web-production-8db69.up.railway.app/predict', [
            'text' => $request->text
            ]);

            if (!$response->successful()) {
                return response()->json([
                    'message' => 'Flask API error',
                    'error' => $response->body()
                ], 500);
            }

            $result = $response->json();

            $tweet = Tweet::create([
                'tweet_id' => uniqid('TW_'),
                'username_x' => $request->username_x ?? 'extension_user',
                'tweet' => $result['text'] ?? $request->text,
                'sentiment' => ucfirst($result['sentiment'] ?? 'Neutral'),
                'hate_speech' => ($result['hate_speech'] ?? 0) == 1 ? 'Ya' : 'Tidak',
                'sarcasm' => ($result['sarcasm'] ?? 0) == 1 ? 'Ya' : 'Tidak',
                'confidence_score' => $result['confidence_sentiment'] ?? 0,
            ]);

            return response()->json([
                'message' => 'Prediksi berhasil',
                'data' => $tweet,
                'prediction' => $result
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Laravel error',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}