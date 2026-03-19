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
        Schema::table('surveys', function (Blueprint $table) {
            // Multinomial (3-class) sentiment output based on feedback_text + part3 open-ended answers
            $table->string('text_sentiment')->nullable();
            $table->decimal('text_sentiment_score', 3, 1)->nullable();
            $table->json('text_sentiment_probabilities')->nullable();

            // Linear regression predicted numeric score based on stars (part2 average)
            $table->decimal('stars_linear_predicted_score', 3, 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn([
                'text_sentiment',
                'text_sentiment_score',
                'text_sentiment_probabilities',
                'stars_linear_predicted_score',
            ]);
        });
    }
};

