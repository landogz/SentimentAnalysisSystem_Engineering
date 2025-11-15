@extends('layouts.app')

@section('title', 'Dashboard - Student Feedback System')

@section('page-title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #98AAE7 0%, #7a8cd6 100%);
        --success-gradient: linear-gradient(135deg, #8FCFA8 0%, #7bb894 100%);
        --danger-gradient: linear-gradient(135deg, #FF4E00 0%, #E64500 100%);
        --warning-gradient: linear-gradient(135deg, #F5B445 0%, #e4a23d 100%);
    }

    /* Animated Background */
    .dashboard-wrapper {
        position: relative;
        overflow: hidden;
    }

    .dashboard-wrapper::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(152, 170, 231, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
        pointer-events: none;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-card:hover::before {
        opacity: 1;
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
        background: linear-gradient(135deg, #494850 0%, #6a6a7a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-card .stat-label {
        font-size: 1rem;
        font-weight: 600;
        color: #494850;
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

    /* Equal Height Cards Row */
    .equal-height-row {
        display: flex;
        flex-wrap: wrap;
    }

    .equal-height-row > [class*="col-"] {
        display: flex;
        flex-direction: column;
    }

    .equal-height-row .modern-card {
        display: flex;
        flex-direction: column;
        height: 100%;
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
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.5rem;
    }

    .modern-card .card-body {
        padding: 2rem;
        overflow: visible;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .modern-card .card-body .chart-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 200px;
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

    /* Top Rated Items */
    .top-rated-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.25rem 1.25rem 4rem;
        margin-bottom: 1rem;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(248, 249, 250, 0.8) 100%);
        border: 1px solid rgba(152, 170, 231, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: visible;
    }

    .top-rated-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: var(--primary-gradient);
        transform: scaleY(0);
        transition: transform 0.3s ease;
    }

    .top-rated-item:hover {
        transform: translateX(10px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .top-rated-item:hover::before {
        transform: scaleY(1);
    }

    .top-rated-item .rank-badge {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(152, 170, 231, 0.4);
        z-index: 1;
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

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card,
    .modern-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-card {
            padding: 1.5rem;
        }

        .stat-card .stat-value {
            font-size: 2rem;
        }

        .stat-card .stat-icon {
            font-size: 3rem;
        }

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

<div class="dashboard-wrapper">

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-lg-3 col-6">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-value">{{ number_format($totalSurveys) }}</div>
            <div class="stat-label">Total Surveys</div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-value">{{ number_format($totalTeachers) }}</div>
            <div class="stat-label">Total Teachers</div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-value">{{ number_format($totalSubjects) }}</div>
            <div class="stat-label">Total Subjects</div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-value">{{ number_format($averageRating, 1) }}</div>
            <div class="stat-label">Average Rating</div>
        </div>
    </div>
</div>

<div class="row equal-height-row">
    <!-- Sentiment Statistics -->
    <div class="col-lg-6">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    Sentiment Analysis
                </h3>
            </div>
            <div class="card-body">
                <div class="sentiment-analysis-body">
                    <div class="sentiment-chart-container">
                        <div class="chart-container">
                            <canvas id="sentimentPieChart" style="height: 220px;"></canvas>
                        </div>
                    </div>
                    <div class="sentiment-breakdown">
                        <div class="sentiment-stat positive">
                            <div class="sentiment-stat-icon">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                            <div class="sentiment-stat-content">
                                <div class="sentiment-stat-label">Positive</div>
                                <div class="sentiment-stat-value">{{ $sentimentStats['positive'] }}</div>
                            </div>
                        </div>
                        <div class="sentiment-stat neutral">
                            <div class="sentiment-stat-icon">
                                <i class="fas fa-minus-circle"></i>
                            </div>
                            <div class="sentiment-stat-content">
                                <div class="sentiment-stat-label">Neutral</div>
                                <div class="sentiment-stat-value">{{ $sentimentStats['neutral'] }}</div>
                            </div>
                        </div>
                        <div class="sentiment-stat negative">
                            <div class="sentiment-stat-icon">
                                <i class="fas fa-thumbs-down"></i>
                            </div>
                            <div class="sentiment-stat-content">
                                <div class="sentiment-stat-label">Negative</div>
                                <div class="sentiment-stat-value">{{ $sentimentStats['negative'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends Chart -->
    <div class="col-lg-6">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Monthly Trends
                </h3>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="monthlyTrendsChart" style="height: 220px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Teachers -->
    <div class="col-lg-6">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-trophy"></i>
                    Top Rated Teachers
                </h3>
            </div>
            <div class="card-body">
                @if($topTeachers->count() > 0)
                    @foreach($topTeachers as $index => $teacher)
                        <div class="top-rated-item">
                            <div class="rank-badge">{{ $index + 1 }}</div>
                            <div style="flex: 1;">
                                <h6 class="mb-1" style="font-weight: 600; color: #494850;">{{ $teacher->name }}</h6>
                                <small class="text-muted">{{ $teacher->department }}</small>
                            </div>
                            <div class="text-right">
                                <div class="rating-stars mb-1">
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
                                <small class="text-muted" style="font-weight: 600;">{{ number_format($teacher->surveys_avg_rating, 1) }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">No data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Subjects -->
    <div class="col-lg-6">
        <div class="modern-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-medal"></i>
                    Top Rated Subjects
                </h3>
            </div>
            <div class="card-body">
                @if($topSubjects->count() > 0)
                    @foreach($topSubjects as $index => $subject)
                        <div class="top-rated-item">
                            <div class="rank-badge">{{ $index + 1 }}</div>
                            <div style="flex: 1;">
                                <h6 class="mb-1" style="font-weight: 600; color: #494850;">{{ $subject->name }}</h6>
                                <small class="text-muted">{{ $subject->subject_code }}</small>
                            </div>
                            <div class="text-right">
                                <div class="rating-stars mb-1">
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
                                <small class="text-muted" style="font-weight: 600;">{{ number_format($subject->surveys_avg_rating, 1) }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">No data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Surveys -->
    <div class="col-lg-12">
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
                                        <strong style="color: #494850;">{{ $survey->teacher->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $survey->teacher->department }}</small>
                                    </td>
                                    <td>
                                        <strong style="color: #494850;">{{ $survey->subject->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $survey->subject->subject_code }}</small>
                                    </td>
                                    <td>
                                        <div class="rating-stars mb-1">
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
                                        <small class="text-muted" style="font-weight: 600;">{{ number_format($survey->rating, 1) }}</small>
                                    </td>
                                    <td>
                                        @if($survey->sentiment === 'positive')
                                            <span class="badge badge-success" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 20px;">{{ ucfirst($survey->sentiment) }}</span>
                                        @elseif($survey->sentiment === 'negative')
                                            <span class="badge badge-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 20px;">{{ ucfirst($survey->sentiment) }}</span>
                                        @else
                                            <span class="badge badge-warning" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 20px;">{{ ucfirst($survey->sentiment) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted" style="font-weight: 500;">{{ $survey->created_at->format('M d, Y') }}</small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No recent surveys</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <!-- Close dashboard-wrapper -->
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
                backgroundColor: ['#8FCFA8', '#F5B445', '#FF4E00'], // Green, Yellow, Red
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