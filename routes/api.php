<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;

Route::post('/predict-tweet', [PredictionController::class, 'predict']);