@extends('layouts.app')

@section('title', 'Subject Details - Student Feedback System')

@section('page-title', 'Subject Details')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('subjects.index') }}">Subjects</a></li>
<li class="breadcrumb-item active">{{ $subject->name }}</li>
@endsection

@section('content')
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

    /* Enhanced Statistics Cards */
    .stat-card {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-card .stat-icon {
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
        font-size: 4rem;
        opacity: 0.2;
        transition: all 0.4s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.2) rotate(10deg);
        opacity: 0.3;
    }

    .stat-card .stat-value {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: white;
    }

    .stat-card .stat-label {
        font-size: 1rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.9);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-card.success {
        background: var(--success-gradient);
    }

    .stat-card.danger {
        background: var(--danger-gradient);
    }

    .stat-card.warning {
        background: var(--warning-gradient);
    }

    .stat-card.info {
        background: var(--primary-gradient);
    }

    /* Enhanced Table */
    .modern-table {
        border-radius: 16px;
        overflow: hidden;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #98AAE7 0%, #7a8cd6 100%);
    }

    .modern-table thead th {
        color: white;
        font-weight: 600;
        padding: 1.25rem;
        border: none;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(152, 170, 231, 0.1);
    }

    .modern-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(152, 170, 231, 0.05) 0%, rgba(143, 207, 168, 0.05) 100%);
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 1.25rem;
        vertical-align: middle;
    }

    .info-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #98AAE7 0%, #7a8cd6 100%);
        color: white;
        border-radius: 20px;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 20px rgba(152, 170, 231, 0.3);
    }

    /* Sentiment Analysis Layout */
    .sentiment-analysis-body {
        display: flex;
        gap: 2rem;
        align-items: center;
        height: 100%;
    }

    .sentiment-chart-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sentiment-breakdown {
        flex: 0 0 250px;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Sentiment Stats List Items */
    .sentiment-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .sentiment-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .sentiment-stat:hover::before {
        left: 100%;
    }

    .sentiment-stat:hover {
        transform: translateX(5px);
    }

    .sentiment-stat.positive {
        background: linear-gradient(135deg, rgba(143, 207, 168, 0.15) 0%, rgba(143, 207, 168, 0.05) 100%);
        border-left: 4px solid #8FCFA8;
    }

    .sentiment-stat.neutral {
        background: linear-gradient(135deg, rgba(245, 180, 69, 0.15) 0%, rgba(245, 180, 69, 0.05) 100%);
        border-left: 4px solid #F5B445;
    }

    .sentiment-stat.negative {
        background: linear-gradient(135deg, rgba(255, 78, 0, 0.15) 0%, rgba(255, 78, 0, 0.05) 100%);
        border-left: 4px solid #FF4E00;
    }

    .sentiment-stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .sentiment-stat.positive .sentiment-stat-icon {
        background: rgba(143, 207, 168, 0.2);
        color: #8FCFA8;
    }

    .sentiment-stat.neutral .sentiment-stat-icon {
        background: rgba(245, 180, 69, 0.2);
        color: #F5B445;
    }

    .sentiment-stat.negative .sentiment-stat-icon {
        background: rgba(255, 78, 0, 0.2);
        color: #FF4E00;
    }

    .sentiment-stat-content {
        flex: 1;
    }

    .sentiment-stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .sentiment-stat-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
    }

    .sentiment-stat.positive .sentiment-stat-value {
        color: #8FCFA8;
    }

    .sentiment-stat.neutral .sentiment-stat-value {
        color: #F5B445;
    }

    .sentiment-stat.negative .sentiment-stat-value {
        color: #FF4E00;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        padding: 1rem;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
        border-radius: 16px;
        border: 1px solid rgba(152, 170, 231, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .sentiment-analysis-body {
            flex-direction: column;
            gap: 1.5rem;
        }

        .sentiment-breakdown {
            flex: 1;
            width: 100%;
        }

        .sentiment-chart-container {
            width: 100%;
        }
    }
</style>

<div class="row">
    <!-- Subject Information -->
    <div class="col-lg-4">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-book"></i>
                    Subject Information
                </h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="info-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Subject Code:</strong></td>
                        <td><span class="badge badge-info">{{ $subject->subject_code }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $subject->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Program:</strong></td>
                        <td>
                            @if($subject->program)
                                <span class="badge badge-info">BS {{ $subject->program }}</span>
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if($subject->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td>{{ $subject->created_at->format('M d, Y') }}</td>
                    </tr>
                </table>

                @if($subject->description)
                    <hr>
                    <h6><strong>Description:</strong></h6>
                    <p class="text-muted">{{ $subject->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="col-lg-8">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card info">
                    <div class="stat-value">{{ $subject->total_surveys }}</div>
                    <div class="stat-label">Total Surveys</div>
                    <div class="stat-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card success">
                    <div class="stat-value">{{ number_format($subject->average_rating, 1) }}</div>
                    <div class="stat-label">Average Rating</div>
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card warning">
                    <div class="stat-value">{{ $sentimentStats['total'] }}</div>
                    <div class="stat-label">Total Feedback</div>
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sentiment Analysis -->
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Sentiment Analysis
                </h3>
            </div>
            <div class="card-body">
                <div class="sentiment-analysis-body">
                    <div class="sentiment-chart-container">
                        <div class="chart-container">
                            <canvas id="subjectSentimentPieChart" style="height: 220px;"></canvas>
                        </div>
                    </div>
                    <div class="sentiment-breakdown">
                        <div class="sentiment-stat positive">
                            <div class="sentiment-stat-icon">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                            <div class="sentiment-stat-content">
                                <div class="sentiment-stat-label">Positive</div>
                                <div class="sentiment-stat-value">{{ $sentimentStats['positive']['count'] }}</div>
                            </div>
                        </div>
                        <div class="sentiment-stat neutral">
                            <div class="sentiment-stat-icon">
                                <i class="fas fa-minus-circle"></i>
                            </div>
                            <div class="sentiment-stat-content">
                                <div class="sentiment-stat-label">Neutral</div>
                                <div class="sentiment-stat-value">{{ $sentimentStats['neutral']['count'] }}</div>
                            </div>
                        </div>
                        <div class="sentiment-stat negative">
                            <div class="sentiment-stat-icon">
                                <i class="fas fa-thumbs-down"></i>
                            </div>
                            <div class="sentiment-stat-content">
                                <div class="sentiment-stat-label">Negative</div>
                                <div class="sentiment-stat-value">{{ $sentimentStats['negative']['count'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Recent Surveys -->
<div class="row">
    <div class="col-12">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clock"></i>
                    Recent Surveys
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student</th>
                                <th>Rating</th>
                                <th>Sentiment</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subject->surveys->take(10) as $survey)
                            <tr class="survey-row" data-survey-id="{{ $survey->id }}" style="cursor: pointer;">
                                <td>{{ $survey->created_at->format('M d, Y') }}</td>
                                <td>{{ $survey->student_name ?? 'Anonymous' }}</td>
                                <td>
                                    <span class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $survey->rating)
                                                <i class="fas fa-star"></i>
                                            @elseif($i - 0.5 <= $survey->rating)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                    <span class="ml-1">{{ $survey->rating }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $survey->sentiment_badge_class }}">
                                        {{ $survey->sentiment_label }}
                                    </span>
                                </td>
                                <td>
                                    @if($survey->feedback_text)
                                        <span class="text-muted">{{ Str::limit($survey->feedback_text, 50) }}</span>
                                    @else
                                        <span class="text-muted">No feedback</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No surveys submitted yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Survey Responses Modal -->
<div class="modal fade" id="surveyResponsesModal" tabindex="-1" aria-labelledby="surveyResponsesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 24px; border: none; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, rgba(152, 170, 231, 0.1) 0%, rgba(143, 207, 168, 0.1) 100%); border-bottom: 2px solid rgba(152, 170, 231, 0.2); padding: 1.5rem;">
                <h5 class="modal-title" id="surveyResponsesModalLabel" style="font-weight: 700; color: #494850; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-clipboard-list" style="background: linear-gradient(135deg, #98AAE7 0%, #7a8cd6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; font-size: 1.5rem;"></i>
                    Survey Responses
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 2rem; background: rgba(255, 255, 255, 0.95);">
                <div id="surveyResponsesContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3" style="color: #6c757d; font-weight: 500;">Loading survey responses...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: linear-gradient(135deg, rgba(152, 170, 231, 0.05) 0%, rgba(143, 207, 168, 0.05) 100%); border-top: 1px solid rgba(152, 170, 231, 0.2); padding: 1.5rem;">
                <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Subject Sentiment Pie Chart
    const subjectSentimentCtx = document.getElementById('subjectSentimentPieChart').getContext('2d');
    new Chart(subjectSentimentCtx, {
        type: 'pie',
        data: {
            labels: ['Positive', 'Neutral', 'Negative'],
            datasets: [{
                data: [
                    {{ $sentimentStats['positive']['count'] }}, 
                    {{ $sentimentStats['neutral']['count'] }}, 
                    {{ $sentimentStats['negative']['count'] }}
                ],
                backgroundColor: ['#8FCFA8', '#F5B445', '#FF4E00'], // Green, Yellow, Coral-Pink
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Survey row click handler
    $('.survey-row').click(function() {
        const surveyId = $(this).data('survey-id');
        const modal = $('#surveyResponsesModal');
        
        // Show modal with loading state
        modal.modal('show');
        
        // Load survey responses via AJAX
        $.ajax({
            url: `/surveys/${surveyId}/responses`,
            method: 'GET',
            success: function(response) {
                $('#surveyResponsesContent').html(response);
            },
            error: function(xhr) {
                console.error('Survey responses error:', xhr);
                let errorMessage = 'Failed to load survey responses. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                $('#surveyResponsesContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        ${errorMessage}
                    </div>
                `);
            }
        });
    });

    // Hover effect for survey rows
    $('.survey-row').hover(
        function() {
            $(this).addClass('table-hover');
        },
        function() {
            $(this).removeClass('table-hover');
        }
    );
});
</script>
@endpush 