<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Subject;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Services\SentimentAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SurveyController extends Controller
{
    protected $sentimentService;

    public function __construct(SentimentAnalysisService $sentimentService)
    {
        $this->sentimentService = $sentimentService;
    }

    /**
     * Display the public survey form
     */
    public function index()
    {
        $subjects = Subject::active()->get();
        
        // Load questions organized by parts
        $questions = SurveyQuestion::active()->orderBy('part')->orderBy('order_number')->get();
        $questionsByPart = $questions->groupBy('part');
        
        // For backward compatibility, also provide the old format
        $optionQuestions = $questions->where('question_type', 'option');
        $commentQuestions = $questions->where('question_type', 'comment');
        
        return view('survey.index', compact('subjects', 'questionsByPart', 'optionQuestions', 'commentQuestions'));
    }

    /**
     * Store a new survey submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject_id' => 'required|exists:subjects,id',
            'program' => 'required|string',
            'feedback_text' => 'nullable|string|max:1000',
            'student_name' => 'nullable|string|max:255',
            'question_responses' => 'nullable|array'
        ]);

        // Debug: Log validation errors if any
        if ($validator->fails()) {
            \Log::error('Survey validation failed:', $validator->errors()->toArray());
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Debug: Log the incoming request data
            \Log::info('Survey submission data:', [
                'program' => $request->program,
                'subject_id' => $request->subject_id,
                'question_responses' => $request->question_responses,
                'feedback_text' => $request->feedback_text
            ]);

            $totalRating = 0;
            $ratingCount = 0;
            $allTextResponses = '';
            $questionResponses = [];

            // Process question responses and calculate rating
            if ($request->has('question_responses')) {
                foreach ($request->question_responses as $questionId => $answer) {
                    if (!empty($answer)) {
                        // Store responses for later creation
                        $questionResponses[] = [
                            'survey_question_id' => $questionId,
                            'answer' => $answer
                        ];

                        // Get question type to process rating
                        $question = SurveyQuestion::find($questionId);
                        if ($question) {
                            if ($question->question_type === 'option') {
                                // Option questions contribute directly to rating
                                $totalRating += (int)$answer;
                                $ratingCount++;
                            } else {
                                // Comment questions - add to text for sentiment analysis
                                $allTextResponses .= ' ' . $answer;
                            }
                        }
                    }
                }
            }

            // Add additional feedback text to sentiment analysis
            if ($request->filled('feedback_text')) {
                $allTextResponses .= ' ' . $request->feedback_text;
            }

            // Calculate average rating from option questions
            $averageRating = $ratingCount > 0 ? $totalRating / $ratingCount : 0;

            // Analyze sentiment from all text responses
            $textSentiment = 'neutral';
            $sentimentRating = 3.0; // Default neutral rating

            if (!empty(trim($allTextResponses))) {
                try {
                    $textSentiment = $this->sentimentService->analyzeSentiment($allTextResponses);
                } catch (\Exception $e) {
                    // Fallback to neutral if sentiment analysis fails
                    $textSentiment = 'neutral';
                    \Log::warning('Sentiment analysis failed: ' . $e->getMessage());
                }
                
                // Convert sentiment to numerical rating
                switch ($textSentiment) {
                    case 'positive':
                        $sentimentRating = 4.5;
                        break;
                    case 'negative':
                        $sentimentRating = 1.5;
                        break;
                    case 'neutral':
                    default:
                        $sentimentRating = 3.0;
                        break;
                }
            }

            // Calculate final rating: 70% from option questions, 30% from sentiment
            $finalRating = 0;
            if ($ratingCount > 0) {
                $finalRating = ($averageRating * 0.7) + ($sentimentRating * 0.3);
            } else {
                $finalRating = $sentimentRating;
            }

            // Ensure rating is within 1.0 to 5.0 range
            $finalRating = max(1.0, min(5.0, round($finalRating, 1)));

            // Determine final sentiment based on both text analysis and final rating
            // If rating is very low (< 2.5), it's negative; if very high (> 4.0), it's positive
            if ($finalRating < 2.5) {
                $sentiment = 'negative';
            } elseif ($finalRating > 4.0) {
                $sentiment = 'positive';
            } else {
                // For middle ratings, use text sentiment if available, otherwise neutral
                $sentiment = !empty(trim($allTextResponses)) ? $textSentiment : 'neutral';
            }

            // Use database transaction to ensure data consistency
            try {
                $survey = \DB::transaction(function() use ($request, $finalRating, $sentiment, $questionResponses) {
                    // Create survey - teacher_id is nullable now
                    $survey = Survey::create([
                        'teacher_id' => null,
                        'subject_id' => $request->subject_id,
                        'rating' => $finalRating,
                        'sentiment' => $sentiment,
                        'feedback_text' => $request->feedback_text,
                        'student_name' => $request->student_name,
                        'student_email' => null,
                        'ip_address' => $request->ip()
                    ]);

                    // Create survey responses
                    foreach ($questionResponses as $response) {
                        SurveyResponse::create([
                            'survey_id' => $survey->id,
                            'survey_question_id' => $response['survey_question_id'],
                            'answer' => $response['answer']
                        ]);
                    }

                    return $survey;
                });
            } catch (\Exception $e) {
                \Log::error('Database transaction failed: ' . $e->getMessage());
                throw $e;
            }

            return response()->json([
                'success' => true,
                'message' => 'Survey submitted successfully! Thank you for your feedback.',
                'survey_id' => $survey->id,
                'calculated_rating' => $finalRating
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Survey submission error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting the survey. Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get subjects for a specific program
     */
    public function getSubjectsByProgram(Request $request)
    {
        $program = $request->get('program');
        
        $subjects = Subject::where('program', $program)
        ->active()
        ->get(['id', 'name', 'subject_code']);
        
        return response()->json($subjects);
    }

    /**
     * Display survey results (public view)
     */
    public function results()
    {
        $totalSurveys = Survey::count();
        $averageRating = Survey::avg('rating') ?? 0.0;
        
        $sentimentStats = [
            'positive' => Survey::where('sentiment', 'positive')->count(),
            'negative' => Survey::where('sentiment', 'negative')->count(),
            'neutral' => Survey::where('sentiment', 'neutral')->count(),
        ];
        
        $topTeachers = Teacher::withCount('surveys')
            ->withAvg('surveys', 'rating')
            ->having('surveys_count', '>', 0)
            ->orderBy('surveys_avg_rating', 'desc')
            ->limit(10)
            ->get();
        
        return view('survey.results', compact(
            'totalSurveys',
            'averageRating',
            'sentimentStats',
            'topTeachers'
        ));
    }

    /**
     * Validate survey form via AJAX
     */
    public function validateForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
            'rating' => 'required|numeric|min:1.0|max:5.0',
            'feedback_text' => 'nullable|string|max:1000',
            'student_name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'valid' => false,
                'errors' => $validator->errors()
            ]);
        }

        return response()->json([
            'valid' => true
        ]);
    }

    /**
     * Get survey responses for a specific survey
     */
    public function getResponses(Survey $survey)
    {
        $responses = $survey->responses()->with('question')->get();
        
        // Group responses by part - filter by the related question's part
        $part1Responses = $responses->filter(function($response) {
            return $response->question && $response->question->part === 'part1';
        });
        $part2Responses = $responses->filter(function($response) {
            return $response->question && $response->question->part === 'part2';
        });
        $part3Responses = $responses->filter(function($response) {
            return $response->question && $response->question->part === 'part3';
        });
        
        // Calculate part-specific averages - only for option questions (numeric answers)
        $part1Average = $part1Responses->count() > 0 
            ? $part1Responses->filter(function($r) { return is_numeric($r->answer); })->avg(function($r) { return (float)$r->answer; }) 
            : 0;
        $part2Average = $part2Responses->count() > 0 
            ? $part2Responses->filter(function($r) { return is_numeric($r->answer); })->avg(function($r) { return (float)$r->answer; }) 
            : 0;
        
        // Calculate overall option average (Part 1 + Part 2 combined)
        $allOptionResponses = $part1Responses->merge($part2Responses);
        $overallOptionAverage = $allOptionResponses->count() > 0
            ? $allOptionResponses->filter(function($r) { return is_numeric($r->answer); })->avg(function($r) { return (float)$r->answer; })
            : 0;
        
        // Analyze Part 3 sentiment and calculate score
        $part3Sentiment = 'neutral';
        $part3Score = 3.0; // Default neutral score
        $part3Comments = $part3Responses->pluck('answer')->filter()->join(' ');
        
        if (!empty($part3Comments)) {
            $sentimentService = new \App\Services\SentimentAnalysisService();
            try {
                $analysis = $sentimentService->analyzeSentimentWithScore($part3Comments);
                $part3Sentiment = $analysis['sentiment'];
                
                // Convert sentiment to numerical score (1-5 scale)
                switch ($part3Sentiment) {
                    case 'positive':
                        $part3Score = 4.5; // High positive score
                        break;
                    case 'negative':
                        $part3Score = 1.5; // Low negative score
                        break;
                    case 'neutral':
                    default:
                        $part3Score = 3.0; // Neutral score
                        break;
                }
                
                // Adjust score based on sentiment intensity
                if (isset($analysis['score'])) {
                    $sentimentIntensity = abs($analysis['score']);
                    if ($sentimentIntensity > 5) {
                        // Very strong sentiment
                        if ($part3Sentiment === 'positive') {
                            $part3Score = min(5.0, $part3Score + 0.5);
                        } elseif ($part3Sentiment === 'negative') {
                            $part3Score = max(1.0, $part3Score - 0.5);
                        }
                    } elseif ($sentimentIntensity < 2) {
                        // Weak sentiment
                        $part3Score = 3.0; // Move towards neutral
                    }
                }
            } catch (\Exception $e) {
                // Fallback to neutral if sentiment analysis fails
                $part3Sentiment = 'neutral';
                $part3Score = 3.0;
            }
        }
        
        // Calculate final rating breakdown (same as in store method)
        // Final Rating = (Overall Option Average * 0.7) + (Part 3 Sentiment Score * 0.3)
        $calculatedFinalRating = ($overallOptionAverage * 0.7) + ($part3Score * 0.3);
        $calculatedFinalRating = max(1.0, min(5.0, round($calculatedFinalRating, 1)));
        
        return view('surveys.responses', compact(
            'survey', 
            'part1Responses', 
            'part2Responses',
            'part3Responses',
            'part1Average',
            'part2Average',
            'part3Sentiment',
            'part3Score',
            'overallOptionAverage',
            'calculatedFinalRating'
        ));
    }
}
