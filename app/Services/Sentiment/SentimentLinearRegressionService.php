<?php

namespace App\Services\Sentiment;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SentimentLinearRegressionService
{
    private const CACHE_KEY = 'sentiment_linear_regression_coeffs_v1';
    private const CACHE_TTL_SECONDS = 600; // 10 minutes

    /**
     * Predict numeric sentiment score (1.0 - 5.0) from star rating average.
     *
     * Linear Regression model (a*x + b) where:
     * - x = average of part2 option answers (1-5 scale)
     * - y = numeric sentiment score (derived from text_sentiment_score if present, else mapping from surveys.sentiment)
     *
     * @return array{predicted_score: float, a: float, b: float, trained_points: int}
     */
    public function predictFromStars(float $starsAverage): array
    {
        $coeffs = Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
            return $this->fitCoefficients();
        });

        $a = $coeffs['a'];
        $b = $coeffs['b'];
        $n = $coeffs['n'];

        // If not enough data, coefficients fallback will be applied.
        $pred = ($a * $starsAverage) + $b;
        $pred = max(1.0, min(5.0, round($pred, 1)));

        return [
            'predicted_score' => $pred,
            'a' => $a,
            'b' => $b,
            'trained_points' => $n,
        ];
    }

    private function fitCoefficients(): array
    {
        // Limit training rows to keep request time reasonable.
        $rows = DB::table('surveys')
            ->join('survey_responses', 'survey_responses.survey_id', '=', 'surveys.id')
            ->join('survey_questions', 'survey_questions.id', '=', 'survey_responses.survey_question_id')
            ->where('survey_questions.part', '=', 'part2')
            ->where('survey_questions.question_type', '=', 'option')
            ->selectRaw('
                surveys.text_sentiment_score as text_sentiment_score,
                surveys.sentiment as sentiment,
                AVG(survey_responses.answer) as stars_avg
            ')
            ->groupBy('surveys.id', 'surveys.text_sentiment_score', 'surveys.sentiment')
            ->havingRaw('COUNT(survey_responses.id) > 0')
            ->orderByDesc('surveys.created_at')
            ->limit(500)
            ->get();

        $xs = [];
        $ys = [];

        foreach ($rows as $row) {
            $x = (float) $row->stars_avg;
            if ($x <= 0) {
                continue;
            }

            $y = $row->text_sentiment_score !== null
                ? (float) $row->text_sentiment_score
                : $this->mapSentimentToNumeric((string) $row->sentiment);

            $xs[] = $x;
            $ys[] = $y;
        }

        $n = count($xs);
        if ($n < 2) {
            return ['a' => 1.0, 'b' => 0.0, 'n' => $n];
        }

        $meanX = array_sum($xs) / $n;
        $meanY = array_sum($ys) / $n;

        $num = 0.0;
        $den = 0.0;

        for ($i = 0; $i < $n; $i++) {
            $dx = $xs[$i] - $meanX;
            $dy = $ys[$i] - $meanY;
            $num += ($dx * $dy);
            $den += ($dx * $dx);
        }

        if (abs($den) < 0.00001) {
            return ['a' => 1.0, 'b' => 0.0, 'n' => $n];
        }

        $a = $num / $den;
        $b = $meanY - ($a * $meanX);

        // Clamp coefficients lightly to avoid extreme predictions.
        if (!is_finite($a) || !is_finite($b)) {
            return ['a' => 1.0, 'b' => 0.0, 'n' => $n];
        }

        return ['a' => $a, 'b' => $b, 'n' => $n];
    }

    private function mapSentimentToNumeric(string $sentiment): float
    {
        return match ($sentiment) {
            'positive' => 4.5,
            'negative' => 1.5,
            'neutral' => 3.0,
            default => 3.0,
        };
    }
}

