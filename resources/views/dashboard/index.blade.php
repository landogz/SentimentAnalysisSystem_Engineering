@extends('layouts.app')

@section('title', 'Dashboard - Student Feedback System')

@section('page-title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<style>
    /* Equal height cards for all rows */
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    
    .row > [class*="col-"] {
        display: flex;
        flex-direction: column;
    }
    
    .row > [class*="col-"] .card {
        flex: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .row > [class*="col-"] .card .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    /* Specific styling for sentiment analysis card */
    .sentiment-card .card-body .row {
        flex: 1;
    }
    
    .sentiment-card .card-body .row .col-6:last-child {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    /* Ensure small-box cards have equal height */
    .small-box {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .small-box .inner {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
</style>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg, #8EA604 0%, #7a9504 100%); color: white;">
            <div class="inner">
                <h3>{{ number_format($totalSurveys) }}</h3>
                <p>Total Surveys</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg, #F5BB00 0%, #e4aa00 100%); color: #494850;">
            <div class="inner">
                <h3>{{ number_format($totalTeachers) }}</h3>
                <p>Total Teachers</p>
            </div>
            <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg, #EC9F05 0%, #db8e04 100%); color: white;">
            <div class="inner">
                <h3>{{ number_format($totalSubjects) }}</h3>
                <p>Total Subjects</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box" style="background: linear-gradient(135deg, #BF3100 0%, #ae2a00 100%); color: white;">
            <div class="inner">
                <h3>{{ number_format($averageRating, 1) }}</h3>
                <p>Average Rating</p>
            </div>
            <div class="icon">
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sentiment Analysis - Full Width -->
    <div class="col-lg-6">
        <div class="card card-outline sentiment-card" style="border-color: var(--light-green);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--light-green) 0%, #7a9504 100%); color: white;">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Sentiment Analysis
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <canvas id="sentimentPieChart" style="height: 200px;"></canvas>
                    </div>
                    <div class="col-6">
                        <div class="d-flex flex-column justify-content-center h-100">
                            <div class="text-center mb-4">
                                <div class="text-success mb-2">
                                    <i class="fas fa-thumbs-up fa-3x"></i>
                                </div>
                                <h3 class="text-success mb-0">{{ $sentimentStats['positive'] }}</h3>
                                <small class="text-muted">Positive</small>
                            </div>
                            <div class="text-center mb-4">
                                <div class="text-warning mb-2">
                                    <i class="fas fa-minus-circle fa-3x"></i>
                                </div>
                                <h3 class="text-warning mb-0">{{ $sentimentStats['neutral'] }}</h3>
                                <small class="text-muted">Neutral</small>
                            </div>
                            <div class="text-center">
                                <div class="text-danger mb-2">
                                    <i class="fas fa-thumbs-down fa-3x"></i>
                                </div>
                                <h3 class="text-danger mb-0">{{ $sentimentStats['negative'] }}</h3>
                                <small class="text-muted">Negative</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends Chart -->
    <div class="col-lg-6">
        <div class="card card-outline" style="border-color: var(--golden-orange);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--golden-orange) 0%, #e4aa00 100%); color: #494850;">
                <h3 class="card-title">
                    <i class="fas fa-chart-line mr-2"></i>
                    Monthly Trends
                </h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyTrendsChart" style="height: 280px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Rated Teachers -->
    <div class="col-lg-4">
        <div class="card card-outline" style="border-color: var(--coral-pink);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--coral-pink) 0%, #e55a5c 100%); color: white;">
                <h3 class="card-title">
                    <i class="fas fa-trophy mr-2"></i>
                    Top Rated Teachers
                </h3>
            </div>
            <div class="card-body">
                @if($topTeachers->count() > 0)
                    @foreach($topTeachers as $teacher)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background: rgba(255, 78, 0, 0.05); border-radius: 8px;">
                            <div>
                                <h6 class="mb-0">{{ $teacher->name }}</h6>
                                <small class="text-muted">{{ $teacher->department }}</small>
                            </div>
                            <div class="text-right">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $teacher->surveys_avg_rating)
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $teacher->surveys_avg_rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted">{{ number_format($teacher->surveys_avg_rating, 1) }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Rated Subjects -->
    <div class="col-lg-4">
        <div class="card card-outline" style="border-color: var(--light-blue);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--light-blue) 0%, #db8e04 100%); color: white;">
                <h3 class="card-title">
                    <i class="fas fa-medal mr-2"></i>
                    Top Rated Subjects
                </h3>
            </div>
            <div class="card-body">
                @if($topSubjects->count() > 0)
                    @foreach($topSubjects as $subject)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2" style="background: rgba(236, 159, 5, 0.05); border-radius: 8px;">
                            <div>
                                <h6 class="mb-0">{{ $subject->name }}</h6>
                                <small class="text-muted">{{ $subject->subject_code }}</small>
                            </div>
                            <div class="text-right">
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $subject->surveys_avg_rating)
                                            <i class="fas fa-star"></i>
                                        @elseif($i - 0.5 <= $subject->surveys_avg_rating)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted">{{ number_format($subject->surveys_avg_rating, 1) }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activity Summary -->
    <div class="col-lg-4">
        <div class="card card-outline" style="border-color: var(--dark-gray);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--dark-gray) 0%, #ae2a00 100%); color: white;">
                <h3 class="card-title">
                    <i class="fas fa-activity mr-2"></i>
                    Recent Activity
                </h3>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="text-primary mb-0">{{ $recentSurveys->count() }}</h2>
                    <small class="text-muted">New Surveys Today</small>
                </div>
                <div class="text-center mb-4">
                    <h4 class="text-success mb-0">{{ number_format($averageRating, 1) }}</h4>
                    <small class="text-muted">Average Rating</small>
                </div>
                <div class="text-center">
                    <h4 class="text-warning mb-0">{{ $totalTeachers }}</h4>
                    <small class="text-muted">Active Teachers</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Surveys - Full Width -->
    <div class="col-12">
        <div class="card card-outline" style="border-color: var(--light-green);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--light-green) 0%, #7a9504 100%); color: white;">
                <h3 class="card-title">
                    <i class="fas fa-clock mr-2"></i>
                    Recent Surveys
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Subject</th>
                                <th>Rating</th>
                                <th>Sentiment</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSurveys as $survey)
                                <tr>
                                    <td>
                                        <strong>{{ $survey->teacher->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $survey->teacher->department }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $survey->subject->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $survey->subject->subject_code }}</small>
                                    </td>
                                    <td>
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $survey->rating)
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - 0.5 <= $survey->rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">{{ number_format($survey->rating, 1) }}</small>
                                    </td>
                                    <td>
                                        @if($survey->sentiment === 'positive')
                                            <span class="badge badge-success">{{ ucfirst($survey->sentiment) }}</span>
                                        @elseif($survey->sentiment === 'negative')
                                            <span class="badge badge-danger">{{ ucfirst($survey->sentiment) }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ ucfirst($survey->sentiment) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $survey->created_at->format('M d, Y') }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No recent surveys</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Monthly Trends Chart
    const ctx = document.getElementById('monthlyTrendsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($monthlyTrends['labels']),
            datasets: [{
                label: 'Surveys',
                data: @json($monthlyTrends['data']),
                borderColor: '#98AAE7',
                backgroundColor: 'rgba(152, 170, 231, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(73, 72, 80, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Sentiment Pie Chart
    const sentimentCtx = document.getElementById('sentimentPieChart').getContext('2d');
    new Chart(sentimentCtx, {
        type: 'pie',
        data: {
            labels: ['Positive', 'Neutral', 'Negative'],
            datasets: [{
                data: [{{ $sentimentStats['positive'] }}, {{ $sentimentStats['neutral'] }}, {{ $sentimentStats['negative'] }}],
                backgroundColor: ['#8FCFA8', '#F5B445', '#F16E70'], // Green, Yellow, Red
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
});
</script>
@endpush 