@extends('layouts.app')

@section('title', 'Dashboard - Student Feedback System')

@section('page-title', 'Dashboard')

@section('breadcrumb')
<!-- <li class="breadcrumb-item active">Dashboard</li> -->
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
        transition: all 0.3s ease;
    }
    
    .row > [class*="col-"] .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
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
        transition: all 0.3s ease;
    }
    
    .small-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.2) !important;
    }
    
    .small-box .inner {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    /* Activity item hover effects */
    .activity-item {
        transition: all 0.3s ease;
    }
    
    .activity-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Professional table styling */
    .table {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .table thead th {
        background: linear-gradient(135deg, var(--golden-orange) 0%, #e4aa00 100%);
        color: white;
        border: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        padding: 1rem;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background: rgba(245, 187, 0, 0.05);
        transform: scale(1.01);
    }
    
    /* Professional card body padding */
    .card-body {
        padding: 2rem;
    }
    
    /* Enhanced typography */
    .card-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }
    
    /* Professional spacing */
    .mb-4 {
        margin-bottom: 2rem !important;
    }
    
    /* Clickable elements hover effects */
    .clickable-item:hover {
        background: rgba(255, 78, 0, 0.1) !important;
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(255, 78, 0, 0.2);
    }
    
    .clickable-subject:hover {
        background: rgba(236, 159, 5, 0.1) !important;
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(236, 159, 5, 0.2);
    }
    
    /* Table clickable elements */
    .table tbody tr strong[onclick]:hover {
        text-decoration: underline;
        transform: scale(1.05);
    }
</style>

<div class="row">
    <!-- Statistics Cards -->
    <div class="col-lg-3 col-6 mb-4">
        <div class="small-box" style="background: linear-gradient(135deg, #8EA604 0%, #7a9504 100%); color: white; border-radius: 16px; box-shadow: 0 8px 25px rgba(142, 166, 4, 0.2); transition: all 0.3s ease; overflow: hidden; position: relative;">
            <div class="inner" style="padding: 1.5rem;">
                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 2.2rem; margin-bottom: 0.5rem;">{{ number_format($totalSurveys) }}</h3>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1rem; margin-bottom: 0;">Total Surveys</p>
                <div class="trend-indicator" style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.2); padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                    <i class="fas fa-arrow-up"></i> +15%
                </div>
            </div>
            <div class="icon" style="position: absolute; bottom: 1rem; right: 1rem; opacity: 0.3; font-size: 3rem;">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6 mb-4">
        <div class="small-box" style="background: linear-gradient(135deg, #F5BB00 0%, #e4aa00 100%); color: #494850; border-radius: 16px; box-shadow: 0 8px 25px rgba(245, 187, 0, 0.2); transition: all 0.3s ease; overflow: hidden; position: relative;">
            <div class="inner" style="padding: 1.5rem;">
                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 2.2rem; margin-bottom: 0.5rem;">{{ number_format($totalTeachers) }}</h3>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1rem; margin-bottom: 0;">Total Teachers</p>
                <div class="trend-indicator" style="position: absolute; top: 1rem; right: 1rem; background: rgba(73, 72, 80, 0.2); padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                    <i class="fas fa-arrow-up"></i> +3
                </div>
            </div>
            <div class="icon" style="position: absolute; bottom: 1rem; right: 1rem; opacity: 0.3; font-size: 3rem;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6 mb-4">
        <div class="small-box" style="background: linear-gradient(135deg, #EC9F05 0%, #db8e04 100%); color: white; border-radius: 16px; box-shadow: 0 8px 25px rgba(236, 159, 5, 0.2); transition: all 0.3s ease; overflow: hidden; position: relative;">
            <div class="inner" style="padding: 1.5rem;">
                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 2.2rem; margin-bottom: 0.5rem;">{{ number_format($totalSubjects) }}</h3>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1rem; margin-bottom: 0;">Total Subjects</p>
                <div class="trend-indicator" style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.2); padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                    <i class="fas fa-arrow-up"></i> +2
                </div>
            </div>
            <div class="icon" style="position: absolute; bottom: 1rem; right: 1rem; opacity: 0.3; font-size: 3rem;">
                <i class="fas fa-book"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6 mb-4">
        <div class="small-box" style="background: linear-gradient(135deg, #BF3100 0%, #ae2a00 100%); color: white; border-radius: 16px; box-shadow: 0 8px 25px rgba(191, 49, 0, 0.2); transition: all 0.3s ease; overflow: hidden; position: relative;">
            <div class="inner" style="padding: 1.5rem;">
                <h3 style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 2.2rem; margin-bottom: 0.5rem;">{{ number_format($averageRating, 1) }}</h3>
                <p style="font-family: 'Poppins', sans-serif; font-weight: 500; font-size: 1rem; margin-bottom: 0;">Average Rating</p>
                <div class="trend-indicator" style="position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.2); padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600;">
                    <i class="fas fa-arrow-up"></i> +0.2
                </div>
            </div>
            <div class="icon" style="position: absolute; bottom: 1rem; right: 1rem; opacity: 0.3; font-size: 3rem;">
                <i class="fas fa-star"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sentiment Analysis - Full Width -->
    <div class="col-lg-6">
        <div class="card card-outline sentiment-card" style="border-color: var(--light-green); border-radius: 16px; box-shadow: 0 8px 25px rgba(142, 166, 4, 0.1);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--light-green) 0%, #7a9504 100%); color: white; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-chart-pie mr-2" style="font-size: 1.2rem;"></i>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">Sentiment Analysis</span>
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
        <div class="card card-outline" style="border-color: var(--golden-orange); border-radius: 16px; box-shadow: 0 8px 25px rgba(245, 187, 0, 0.1);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--golden-orange) 0%, #e4aa00 100%); color: #494850; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-chart-line mr-2" style="font-size: 1.2rem;"></i>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">Monthly Trends</span>
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
        <div class="card card-outline" style="border-color: var(--coral-pink); border-radius: 16px; box-shadow: 0 8px 25px rgba(255, 78, 0, 0.1);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--coral-pink) 0%, #e55a5c 100%); color: white; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-trophy mr-2" style="font-size: 1.2rem;"></i>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">Top Rated Teachers</span>
                </h3>
            </div>
            <div class="card-body">
                @if($topTeachers->count() > 0)
                    @foreach($topTeachers as $teacher)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 clickable-item" style="background: rgba(255, 78, 0, 0.05); border-radius: 8px; transition: all 0.3s ease; cursor: pointer;" onclick="window.location.href='{{ route('teachers.show', $teacher->id) }}'">
                            <div>
                                <h6 class="mb-0" style="color: var(--coral-pink); font-weight: 600; transition: all 0.3s ease;">{{ $teacher->name }}</h6>
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
        <div class="card card-outline" style="border-color: var(--light-blue); border-radius: 16px; box-shadow: 0 8px 25px rgba(236, 159, 5, 0.1);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--light-blue) 0%, #db8e04 100%); color: white; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-medal mr-2" style="font-size: 1.2rem;"></i>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">Top Rated Subjects</span>
                </h3>
            </div>
            <div class="card-body">
                @if($topSubjects->count() > 0)
                    @foreach($topSubjects as $subject)
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 clickable-subject" style="background: rgba(236, 159, 5, 0.05); border-radius: 8px; transition: all 0.3s ease; cursor: pointer;" onclick="window.location.href='{{ route('subjects.show', $subject->id) }}'">
                            <div>
                                <h6 class="mb-0" style="color: var(--light-blue); font-weight: 600; transition: all 0.3s ease;">{{ $subject->name }}</h6>
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
        <div class="card card-outline" style="border-color: var(--dark-gray); border-radius: 16px; box-shadow: 0 8px 25px rgba(191, 49, 0, 0.1);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--dark-gray) 0%, #ae2a00 100%); color: white; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-chart-line mr-2" style="font-size: 1.2rem;"></i>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">Activity Overview</span>
                </h3>
            </div>
            <div class="card-body" style="padding: 2rem;">
                <!-- New Surveys Today -->
                <div class="activity-item mb-4" style="background: linear-gradient(135deg, rgba(142, 166, 4, 0.1) 0%, rgba(142, 166, 4, 0.05) 100%); border-radius: 12px; padding: 1.5rem; border-left: 4px solid var(--light-green);">
                    <div class="d-flex align-items-center">
                        <div class="activity-icon mr-3" style="background: linear-gradient(135deg, var(--light-green) 0%, #7a9504 100%); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clipboard-check" style="color: white; font-size: 1.2rem;"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h4 class="mb-0" style="color: var(--dark-gray); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem;">{{ $recentSurveys->count() }}</h4>
                            <p class="mb-0" style="color: #666; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500;">New Surveys Today</p>
                        </div>
                        <div class="activity-trend" style="color: var(--light-green); font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-arrow-up"></i> +12%
                        </div>
                    </div>
                </div>

                <!-- Average Rating -->
                <div class="activity-item mb-4" style="background: linear-gradient(135deg, rgba(245, 187, 0, 0.1) 0%, rgba(245, 187, 0, 0.05) 100%); border-radius: 12px; padding: 1.5rem; border-left: 4px solid var(--golden-orange);">
                    <div class="d-flex align-items-center">
                        <div class="activity-icon mr-3" style="background: linear-gradient(135deg, var(--golden-orange) 0%, #e4aa00 100%); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-star" style="color: white; font-size: 1.2rem;"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h4 class="mb-0" style="color: var(--dark-gray); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem;">{{ number_format($averageRating, 1) }}</h4>
                            <p class="mb-0" style="color: #666; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500;">Average Rating</p>
                        </div>
                        <div class="activity-trend" style="color: var(--golden-orange); font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-arrow-up"></i> +0.3
                        </div>
                    </div>
                </div>

                <!-- Active Teachers -->
                <div class="activity-item" style="background: linear-gradient(135deg, rgba(255, 78, 0, 0.1) 0%, rgba(255, 78, 0, 0.05) 100%); border-radius: 12px; padding: 1.5rem; border-left: 4px solid var(--coral-pink);">
                    <div class="d-flex align-items-center">
                        <div class="activity-icon mr-3" style="background: linear-gradient(135deg, var(--coral-pink) 0%, #e55a5c 100%); width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users" style="color: white; font-size: 1.2rem;"></i>
                        </div>
                        <div class="activity-content flex-grow-1">
                            <h4 class="mb-0" style="color: var(--dark-gray); font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.8rem;">{{ $totalTeachers }}</h4>
                            <p class="mb-0" style="color: #666; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 500;">Active Teachers</p>
                        </div>
                        <div class="activity-trend" style="color: var(--coral-pink); font-size: 0.8rem; font-weight: 600;">
                            <i class="fas fa-arrow-up"></i> +2
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Surveys - Full Width -->
    <div class="col-12">
        <div class="card card-outline" style="border-color: var(--light-green); border-radius: 16px; box-shadow: 0 8px 25px rgba(142, 166, 4, 0.1);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--light-green) 0%, #7a9504 100%); color: white; border-radius: 16px 16px 0 0; padding: 1.5rem;">
                <h3 class="card-title mb-0">
                    <i class="fas fa-clock mr-2" style="font-size: 1.2rem;"></i>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 600;">Recent Surveys</span>
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
                                        <strong style="color: var(--coral-pink); cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('teachers.show', $survey->teacher->id) }}'">{{ $survey->teacher->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $survey->teacher->department }}</small>
                                    </td>
                                    <td>
                                        <strong style="color: var(--light-blue); cursor: pointer; transition: all 0.3s ease;" onclick="window.location.href='{{ route('subjects.show', $survey->subject->id) }}'">{{ $survey->subject->name }}</strong>
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