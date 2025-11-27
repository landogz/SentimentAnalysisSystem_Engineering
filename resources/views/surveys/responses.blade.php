<!-- Survey Information Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clipboard-list"></i>
                    Survey Information
                </h3>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-2">
                            <i class="fas fa-clipboard-list text-primary me-2"></i>
                            Survey Responses
                        </h5>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Program</small><br>
                                <strong class="text-primary">{{ $survey->subject->program ? 'BS ' . $survey->subject->program : 'N/A' }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Subject</small><br>
                                <strong class="text-info">{{ $survey->subject->name }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Date</small><br>
                                <strong>{{ $survey->created_at->format('M d, Y g:i A') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-flex flex-column align-items-end">
                            <div class="mb-2">
                                <span class="badge {{ $survey->sentiment_badge_class }} fs-6 px-3 py-2">
                                    <i class="fas fa-heart me-1"></i>
                                    {{ ucfirst($survey->sentiment) }}
                                </span>
                            </div>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $survey->rating)
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif($i - 0.5 <= $survey->rating)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-2 fw-bold">{{ $survey->rating }}/5.0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tab Navigation -->
<div class="row mb-4">
    <div class="col-12">
        <ul class="nav nav-tabs nav-fill modern-tabs" id="surveyTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                    <i class="fas fa-chart-bar me-2"></i>Overview
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="part2-tab" data-bs-toggle="tab" data-bs-target="#part2" type="button" role="tab">
                    <i class="fas fa-chart-line me-2"></i>Course Evaluation
                    <span class="badge bg-info ms-1">{{ $part2Responses->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="part3-tab" data-bs-toggle="tab" data-bs-target="#part3" type="button" role="tab">
                    <i class="fas fa-comments me-2"></i>Open Ended Questions
                    <span class="badge bg-success ms-1">{{ $part3Responses->count() }}</span>
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Tab Content -->
<div class="tab-content" id="surveyTabsContent">
    <!-- Overview Tab -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel">
        <div class="row">
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            Survey Analysis Summary
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Analysis Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="analysis-card analysis-card-info">
                                    <div class="text-center p-3">
                                        <div class="analysis-icon bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <h4 class="text-info mb-1">{{ number_format($part2Average, 1) }}</h4>
                                        <p class="mb-0 fw-bold text-dark">Course Evaluation</p>
                                        <small class="text-muted">Level Score</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="analysis-card analysis-card-success">
                                    <div class="text-center p-3">
                                        <div class="analysis-icon bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-comments"></i>
                                        </div>
                                        <h4 class="text-success mb-1">{{ number_format($part3Score, 1) }}</h4>
                                        <p class="mb-0 fw-bold text-dark">Open Ended Questions</p>
                                        <small class="text-muted">Sentiment Score</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="analysis-card analysis-card-warning">
                                    <div class="text-center p-3">
                                        <div class="analysis-icon bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <h4 class="text-warning mb-1">{{ number_format($survey->rating, 1) }}</h4>
                                        <p class="mb-0 fw-bold text-dark">Overall Rating</p>
                                        <small class="text-muted">Combined Score</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Computation Breakdown -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="info-section">
                                    <h6 class="text-muted mb-3">
                                        <i class="fas fa-calculator me-2"></i>Rating Computation Breakdown
                                    </h6>
                                    <div class="computation-breakdown">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="computation-item">
                                                    <small class="text-muted d-block mb-1">Course Evaluation Average</small>
                                                    <strong class="text-info fs-5">{{ number_format($part2Average, 1) }}/5.0</strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="computation-item">
                                                    <small class="text-muted d-block mb-1">Open Ended Questions Sentiment Score</small>
                                                    <strong class="text-success fs-5">{{ number_format($part3Score, 1) }}/5.0</strong>
                                                    <span class="badge bg-secondary ms-2">{{ ucfirst($part3Sentiment) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="my-3">
                                        <div class="computation-formula">
                                            <div class="formula-display bg-light p-3 rounded">
                                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                    <div class="formula-text">
                                                        <strong>Final Rating Formula:</strong><br>
                                                        <small class="text-muted">
                                                            (Course Evaluation Average × 70%) + (Open Ended Questions Sentiment Score × 30%)
                                                        </small>
                                                    </div>
                                                    <div class="formula-calculation text-end">
                                                        <div class="calculation-step">
                                                            <small class="text-muted">= ({{ number_format($part2Average, 1) }} × 0.7) + ({{ number_format($part3Score, 1) }} × 0.3)</small>
                                                        </div>
                                                        <div class="calculation-step mt-1">
                                                            <small class="text-muted">= {{ number_format($part2Average * 0.7, 2) }} + {{ number_format($part3Score * 0.3, 2) }}</small>
                                                        </div>
                                                        <div class="calculation-result mt-2">
                                                            <strong class="text-warning fs-4">= {{ number_format($calculatedFinalRating, 1) }}/5.0</strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Student Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-section">
                                    <h6 class="text-muted mb-3">Student Information</h6>
                                    <div>
                                        <small class="text-muted">Name</small><br>
                                        <strong>{{ $survey->student_name ?: 'Anonymous' }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-section">
                                    <h6 class="text-muted mb-3">Sentiment Analysis</h6>
                                    <div class="sentiment-display">
                                        <span class="badge {{ $survey->sentiment_badge_class }} fs-6 px-3 py-2">
                                            <i class="fas fa-heart me-1"></i>
                                            Overall Sentiment: {{ ucfirst($survey->sentiment) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Part 2 Tab -->
    <div class="tab-pane fade" id="part2" role="tabpanel">
        <div class="row">
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line"></i>
                            Course Evaluation
                            <span class="badge bg-info ms-2">{{ number_format($part2Average, 1) }}/5.0</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($part2Responses->count() > 0)
                            <div class="row">
                                @foreach($part2Responses as $response)
                                <div class="col-md-6 mb-3">
                                    <div class="response-card border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge bg-info">Q{{ $response->question->order_number }}</span>
                                            <span class="badge bg-secondary">{{ $response->answer }}/5</span>
                                        </div>
                                        <p class="mb-2 text-muted small">{{ $response->question->question_text }}</p>
                                        <div class="rating-display">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $response->answer)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No Course Evaluation responses available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Part 3 Tab -->
    <div class="tab-pane fade" id="part3" role="tabpanel">
        <div class="row">
            <div class="col-12">
                <div class="modern-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-comments"></i>
                            Open Ended Questions
                            <span class="badge bg-success ms-2">Sentiment: {{ ucfirst($part3Sentiment) }}</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($part3Responses->count() > 0)
                            @foreach($part3Responses as $response)
                            <div class="comment-card border rounded p-4 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="badge bg-success">Q{{ $response->question->order_number }}</span>
                                    <span class="badge bg-secondary">Comment</span>
                                </div>
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2">Question:</h6>
                                    <p class="mb-0">{{ $response->question->question_text }}</p>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-2">Response:</h6>
                                    <div class="bg-light p-3 rounded">
                                        {{ $response->answer ?: 'No response provided' }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-comment-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No Open Ended Questions responses available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Feedback -->
@if($survey->feedback_text)
<div class="row mt-4">
    <div class="col-12">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-comment-dots"></i>
                    Additional Feedback
                </h3>
            </div>
            <div class="card-body">
                <div class="bg-light p-3 rounded">
                    {{ $survey->feedback_text }}
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #98AAE7 0%, #7a8cd6 100%);
        --success-gradient: linear-gradient(135deg, #8FCFA8 0%, #7bb894 100%);
        --danger-gradient: linear-gradient(135deg, #FF4E00 0%, #E64500 100%);
        --warning-gradient: linear-gradient(135deg, #F5B445 0%, #e4a23d 100%);
    }

    /* Modern Card Design */
    .modern-card {
        border-radius: 24px;
        border: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        margin-bottom: 1.5rem;
    }

    .modern-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
    }

    .modern-card .card-header {
        background: linear-gradient(135deg, rgba(152, 170, 231, 0.1) 0%, rgba(143, 207, 168, 0.1) 100%);
        border-bottom: 2px solid rgba(152, 170, 231, 0.2);
        padding: 1.5rem;
        border-radius: 24px 24px 0 0;
    }

    .modern-card .card-header h3 {
        font-weight: 700;
        font-size: 1.3rem;
        color: #494850;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card .card-header h3 i {
        background: linear-gradient(135deg, #98AAE7 0%, #7a8cd6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.5rem;
    }

    .modern-card .card-body {
        padding: 2rem;
    }

    /* Professional Tab Styling */
    .modern-tabs {
        border-bottom: 2px solid rgba(152, 170, 231, 0.2);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
        border-radius: 16px 16px 0 0;
        padding: 0.5rem;
    }

    .modern-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 12px;
        color: #6c757d;
        font-weight: 600;
        padding: 12px 20px;
        transition: all 0.3s ease;
        margin: 0 0.25rem;
    }

    .modern-tabs .nav-link:hover {
        background: rgba(152, 170, 231, 0.1);
        color: #98AAE7;
    }

    .modern-tabs .nav-link.active {
        border-bottom-color: #98AAE7;
        color: #98AAE7;
        background: linear-gradient(135deg, rgba(152, 170, 231, 0.15) 0%, rgba(143, 207, 168, 0.15) 100%);
    }

    /* Analysis Cards */
    .analysis-card {
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #ffffff;
        border: 1px solid rgba(152, 170, 231, 0.2);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
    }

    .analysis-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    }

    .analysis-card-primary {
        border-left: 4px solid #98AAE7;
        background: linear-gradient(135deg, rgba(152, 170, 231, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .analysis-card-info {
        border-left: 4px solid #0dcaf0;
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .analysis-card-success {
        border-left: 4px solid #8FCFA8;
        background: linear-gradient(135deg, rgba(143, 207, 168, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .analysis-card-warning {
        border-left: 4px solid #F5B445;
        background: linear-gradient(135deg, rgba(245, 180, 69, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .analysis-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Response Cards */
    .response-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
        border: 1px solid rgba(152, 170, 231, 0.2) !important;
        border-radius: 16px !important;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .response-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border-color: rgba(152, 170, 231, 0.4) !important;
    }

    .comment-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
        border: 1px solid rgba(152, 170, 231, 0.2) !important;
        border-radius: 16px !important;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .comment-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        border-color: rgba(152, 170, 231, 0.4) !important;
    }

/* Rating Display */
.rating-display {
    font-size: 0.9rem;
}

.rating-display .fas.fa-star,
.rating-display .far.fa-star {
    font-size: 0.8rem;
}

    /* Info Sections */
    .info-section {
        padding: 20px;
        background: linear-gradient(135deg, rgba(152, 170, 231, 0.05) 0%, rgba(143, 207, 168, 0.05) 100%);
        border-radius: 16px;
        border: 1px solid rgba(152, 170, 231, 0.2);
    }

    /* Computation Breakdown */
    .computation-breakdown {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
        border-radius: 12px;
        padding: 1rem;
    }

    .computation-item {
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 8px;
        border-left: 3px solid #98AAE7;
    }

    .formula-display {
        background: linear-gradient(135deg, rgba(152, 170, 231, 0.1) 0%, rgba(143, 207, 168, 0.1) 100%) !important;
        border: 1px solid rgba(152, 170, 231, 0.3);
    }

    .calculation-step {
        font-family: 'Courier New', monospace;
    }

    .calculation-result {
        border-top: 2px solid rgba(152, 170, 231, 0.3);
        padding-top: 0.5rem;
        margin-top: 0.5rem;
    }

.sentiment-display {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
}

    /* Badge Styling */
    .badge {
        font-weight: 600;
        padding: 0.5em 0.75em;
        border-radius: 8px;
    }

/* Responsive Design */
@media (max-width: 768px) {
    .nav-tabs .nav-link {
        padding: 8px 12px;
        font-size: 0.9rem;
    }
    
    .analysis-card {
        margin-bottom: 1rem;
    }
    
    .response-card {
        margin-bottom: 1rem;
    }
}
</style>
