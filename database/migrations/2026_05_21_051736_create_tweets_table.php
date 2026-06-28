<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('tweets', function (Blueprint $table) {

        $table->id();

        $table->string('tweet_id')->nullable();

        $table->string('username_x');

        $table->text('tweet');

        $table->string('sentiment')->nullable();

        $table->string('hate_speech')->nullable();

        $table->string('sarcasm')->nullable();

        $table->float('confidence_score')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
