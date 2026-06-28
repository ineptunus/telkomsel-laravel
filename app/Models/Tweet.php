<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
   protected $fillable = [
    'tweet_id',
    'username_x',
    'tweet',
    'sentiment',
    'hate_speech',
    'sarcasm',
    'confidence_score'
];

}