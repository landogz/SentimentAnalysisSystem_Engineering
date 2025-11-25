<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        // Get total statistics
        $totalSurveys = Survey::count();
        $totalPrograms = Subject::distinct('program')->whereNotNull('program')->count('program');
        $totalSubjects = Subject::count();
        
        // Get average rating
        $averageRating = Survey::avg('rating') ?? 0.0;
        
        // Get sentiment statistics
        $sentimentStats = [
            'positive' => Survey::where('sentiment', 'positive')->count(),
            'negative' => Survey::where('sentiment', 'negative')->count(),
            'neutral' => Survey::where('sentiment', 'neutral')->count(),
        ];
        
        // Get top rated programs
        $topPrograms = Subject::whereNotNull('program')
            ->whereHas('surveys')
            ->get()
            ->groupBy('program')
            ->map(function($subjects, $program) {
                $totalRating = 0;
                $totalSurveys = 0;
                foreach ($subjects as $subject) {
                    $avgRating = $subject->surveys()->avg('rating') ?? 0;
                    $surveyCount = $subject->surveys()->count();
                    $totalRating += $avgRating * $surveyCount;
                    $totalSurveys += $surveyCount;
                }
                return (object)[
                    'program' => $program,
                    'subjects_count' => $subjects->count(),
                    'avg_rating' => $totalSurveys > 0 ? $totalRating / $totalSurveys : 0
                ];
            })
            ->sortByDesc('avg_rating')
            ->take(5)
            ->values();
        
        // Get top rated subjects
        $topSubjects = Subject::withCount('surveys')
            ->withAvg('surveys', 'rating')
            ->having('surveys_count', '>', 0)
            ->orderBy('surveys_avg_rating', 'desc')
            ->limit(5)
            ->get();
        
        // Get recent surveys
        $recentSurveys = Survey::with(['subject'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get monthly survey trends
        $monthlyTrendsRaw = Survey::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Format monthly trends for chart
        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyTrends = [
            'labels' => [],
            'data' => []
        ];
        
        // Initialize all months with 0 count
        for ($i = 1; $i <= 12; $i++) {
            $monthlyTrends['labels'][] = $monthNames[$i - 1];
            $monthlyTrends['data'][] = 0;
        }
        
        // Fill in actual data
        foreach ($monthlyTrendsRaw as $trend) {
            $monthlyTrends['data'][$trend->month - 1] = $trend->count;
        }
        
        return view('dashboard.index', compact(
            'totalSurveys',
            'totalPrograms', 
            'totalSubjects',
            'averageRating',
            'sentimentStats',
            'topPrograms',
            'topSubjects',
            'recentSurveys',
            'monthlyTrends'
        ));
    }

    /**
     * Get dashboard statistics via AJAX
     */
    public function getStats(Request $request)
    {
        $program = $request->get('program');
        $subjectId = $request->get('subject_id');
        
        $query = Survey::query();
        
        if ($program) {
            $query->whereHas('subject', function($q) use ($program) {
                $q->where('program', $program);
            });
        }
        
        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }
        
        $stats = [
            'total_surveys' => $query->count(),
            'average_rating' => round($query->avg('rating') ?? 0, 1),
            'sentiment_stats' => [
                'positive' => $query->where('sentiment', 'positive')->count(),
                'negative' => $query->where('sentiment', 'negative')->count(),
                'neutral' => $query->where('sentiment', 'neutral')->count(),
            ]
        ];
        
        return response()->json($stats);
    }

    /**
     * Get chart data for dashboard
     */
    public function getChartData()
    {
        // Sentiment distribution
        $sentimentData = Survey::selectRaw('sentiment, COUNT(*) as count')
            ->groupBy('sentiment')
            ->get();
        
        // Rating distribution
        $ratingData = Survey::selectRaw('ROUND(rating, 0) as rating_group, COUNT(*) as count')
            ->groupBy('rating_group')
            ->orderBy('rating_group')
            ->get();
        
        // Monthly trends
        $monthlyData = Survey::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        return response()->json([
            'sentiment' => $sentimentData,
            'rating' => $ratingData,
            'monthly' => $monthlyData
        ]);
    }
}
