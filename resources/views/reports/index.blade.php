@extends('layouts.app')

@section('title', 'Reports - Student Feedback System')

@section('page-title', 'Reports & Analytics')
@section('icon', 'chart-bar')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Reports</li>
@endsection

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #98AAE7 0%, #7a8cd6 100%);
        --success-gradient: linear-gradient(135deg, #8FCFA8 0%, #7bb894 100%);
        --danger-gradient: linear-gradient(135deg, #FF4E00 0%, #E64500 100%);
        --warning-gradient: linear-gradient(135deg, #F5B445 0%, #e4a23d 100%);
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

    /* Filter Panel */
    .filter-panel {
        border-radius: 24px;
        border: none;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        margin-bottom: 1.5rem;
    }

    .filter-panel .card-header {
        background: linear-gradient(135deg, var(--primary-gradient));
        color: white;
        padding: 1.5rem;
        border-radius: 24px 24px 0 0;
    }

    .filter-panel .card-header h3 {
        color: white;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 700;
    }

    .filter-panel .card-header h3 i {
        color: white;
    }

    .filter-panel .form-control,
    .filter-panel .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .filter-panel .form-control:focus,
    .filter-panel .form-select:focus {
        border-color: var(--light-blue);
        box-shadow: 0 0 0 0.2rem rgba(152, 170, 231, 0.25);
    }

    .filter-panel .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
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

        .stat-card {
            padding: 1.5rem;
        }

        .stat-card .stat-value {
            font-size: 2rem;
        }

        .stat-card .stat-icon {
            font-size: 3rem;
        }
    }
</style>

<div class="row">
    <!-- Filter Panel -->
    <div class="col-12">
        <div class="filter-panel card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i>
                    Filter Options
                </h3>
            </div>
            <div class="card-body">
                <form id="reportFilterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="program_filter" class="form-label fw-bold">Program/Course</label>
                                <select class="form-select" id="program_filter" name="program">
                                    <option value="">All Programs</option>
                                    <option value="Civil Engineering">BS Civil Engineering</option>
                                    <option value="Mining Engineering">BS Mining Engineering</option>
                                    <option value="Electrical Engineering">BS Electrical Engineering</option>
                                    <option value="Mechanical Engineering">BS Mechanical Engineering</option>
                                    <option value="Computer Engineering">BS Computer Engineering</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-3">
                                <label for="subject_filter" class="form-label fw-bold">Subject</label>
                                <select class="form-select" id="subject_filter" name="subject_id">
                                    <option value="">All Subjects</option>
                                    @foreach($subjects ?? [] as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label for="date_from" class="form-label fw-bold">From Date</label>
                                <input type="date" class="form-control" id="date_from" name="date_from">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label for="date_to" class="form-label fw-bold">To Date</label>
                                <input type="date" class="form-control" id="date_to" name="date_to">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, var(--light-blue) 0%, #7a8cd6 100%); border: none;">
                                    <i class="fas fa-search me-1"></i>Generate
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="col-lg-3 col-6">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="stat-value" id="totalSurveys">{{ number_format($totalSurveys) }}</div>
            <div class="stat-label">Total Surveys</div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-value" id="avgRating">{{ number_format($averageRating, 1) }}</div>
            <div class="stat-label">Average Rating</div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-thumbs-up"></i>
            </div>
            <div class="stat-value" id="positiveSentiment">{{ $sentimentStats['positive'] }}</div>
            <div class="stat-label">Positive Feedback</div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-thumbs-down"></i>
            </div>
            <div class="stat-value" id="negativeSentiment">{{ $sentimentStats['negative'] }}</div>
            <div class="stat-label">Negative Feedback</div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row equal-height-row">
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
                                    <div class="sentiment-stat-value" id="positiveCount">{{ $sentimentStats['positive'] }}</div>
                                </div>
                            </div>
                            <div class="sentiment-stat neutral">
                                <div class="sentiment-stat-icon">
                                    <i class="fas fa-minus-circle"></i>
                                </div>
                                <div class="sentiment-stat-content">
                                    <div class="sentiment-stat-label">Neutral</div>
                                    <div class="sentiment-stat-value" id="neutralCount">{{ $sentimentStats['neutral'] }}</div>
                                </div>
                            </div>
                            <div class="sentiment-stat negative">
                                <div class="sentiment-stat-icon">
                                    <i class="fas fa-thumbs-down"></i>
                                </div>
                                <div class="sentiment-stat-content">
                                    <div class="sentiment-stat-label">Negative</div>
                                    <div class="sentiment-stat-value" id="negativeCount">{{ $sentimentStats['negative'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="modern-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i>
                        Rating Distribution
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ratingChart" style="height: 220px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Export Options -->
    <!-- <div class="col-12">
        <div class="card card-outline" style="border-color: var(--dark-gray);">
            <div class="card-header" style="background: linear-gradient(135deg, var(--dark-gray) 0%, #5a5a6a 100%); color: white;">
                <h3 class="card-title">
                    <i class="fas fa-download mr-2"></i>
                    Export Reports
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-block" onclick="exportReport('pdf')" style="background: linear-gradient(135deg, var(--light-green) 0%, #7bb894 100%); color: white; border: none;">
                            <i class="fas fa-file-pdf mr-1"></i>Export PDF
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-block" onclick="exportReport('excel')" style="background: linear-gradient(135deg, var(--light-blue) 0%, #7a8cd6 100%); color: white; border: none;">
                            <i class="fas fa-file-excel mr-1"></i>Export Excel
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-block" onclick="exportReport('csv')" style="background: linear-gradient(135deg, var(--golden-orange) 0%, #e4a23d 100%); color: white; border: none;">
                            <i class="fas fa-file-csv mr-1"></i>Export CSV
                        </button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-block" onclick="printReport()" style="background: linear-gradient(135deg, var(--coral-pink) 0%, #e55a5c 100%); color: white; border: none;">
                            <i class="fas fa-print mr-1"></i>Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection

@push('scripts')
<script>
let sentimentChart, ratingChart;

$(document).ready(function() {
    // Initialize charts
    initializeCharts();
    
    // Form submission
    $('#reportFilterForm').submit(function(e) {
        e.preventDefault();
        loadReportData();
    });
});

function initializeCharts() {
    // Sentiment Pie Chart
    const sentimentCtx = document.getElementById('sentimentPieChart').getContext('2d');
    sentimentChart = new Chart(sentimentCtx, {
        type: 'pie',
        data: {
            labels: ['Positive', 'Neutral', 'Negative'],
            datasets: [{
                data: [
                    {{ $sentimentStats['positive'] }},
                    {{ $sentimentStats['neutral'] }},
                    {{ $sentimentStats['negative'] }}
                ],
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

    // Rating Chart - Initialize with data from controller
    const ratingCtx = document.getElementById('ratingChart').getContext('2d');
    
    // Prepare rating distribution data
    const ratingData = [0, 0, 0, 0, 0]; // Initialize with zeros for all 5 ratings
    @if(isset($ratingDistribution))
        @foreach($ratingDistribution as $item)
            @if($item->rating_group >= 1 && $item->rating_group <= 5)
                ratingData[{{ $item->rating_group - 1 }}] = {{ $item->count }};
            @endif
        @endforeach
    @endif
    
    ratingChart = new Chart(ratingCtx, {
        type: 'bar',
        data: {
            labels: ['1★', '2★', '3★', '4★', '5★'],
            datasets: [{
                label: 'Number of Surveys',
                data: ratingData,
                backgroundColor: [
                    '#FF4E00', // Coral Pink for 1 star
                    '#F5B445', // Golden Orange for 2 stars
                    '#98AAE7', // Light Blue for 3 stars
                    '#8FCFA8', // Light Green for 4 stars
                    '#494850'  // Dark Gray for 5 stars
                ],
                borderColor: [
                    '#FF4E00',
                    '#F5B445',
                    '#98AAE7',
                    '#8FCFA8',
                    '#494850'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' surveys';
                        }
                    }
                }
            }
        }
    });
}

function loadReportData() {
    const formData = $('#reportFilterForm').serialize();
    
    $.get('{{ route("reports.filtered-stats") }}', formData, function(data) {
        // Update statistics cards
        $('#totalSurveys').text(data.total_surveys);
        $('#avgRating').text(data.average_rating);
        $('#positiveSentiment').text(data.sentiment_stats.positive);
        $('#negativeSentiment').text(data.sentiment_stats.negative);
        
        // Update sentiment pie chart
        sentimentChart.data.datasets[0].data = [
            data.sentiment_stats.positive,
            data.sentiment_stats.neutral,
            data.sentiment_stats.negative
        ];
        sentimentChart.update();
        
        // Update sentiment statistics display
        $('#positiveCount').text(data.sentiment_stats.positive);
        $('#neutralCount').text(data.sentiment_stats.neutral);
        $('#negativeCount').text(data.sentiment_stats.negative);
        
        // Load rating distribution
        loadRatingDistribution();
    });
}

function loadRatingDistribution() {
    const formData = $('#reportFilterForm').serialize();
    
    $.get('{{ route("reports.rating-distribution") }}', formData, function(data) {
        ratingChart.data.datasets[0].data = data;
        ratingChart.update();
    });
}

function exportReport(format) {
    const formData = $('#reportFilterForm').serialize();
    
    Swal.fire({
        title: 'Generating Report',
        text: `Preparing ${format.toUpperCase()} report...`,
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: '{{ route("reports.export") }}',
        method: 'POST',
        data: formData + '&format=' + format,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                if (format === 'csv') {
                    // For CSV, create a download link
                    const blob = new Blob([response], { type: 'text/csv' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `prmsu-ccit-feedback-report-${new Date().toISOString().slice(0,10)}.csv`;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                    
                    Swal.fire({
                        title: 'Export Complete!',
                        text: 'CSV report has been downloaded successfully.',
                        icon: 'success',
                        confirmButtonColor: '#8FCFA8'
                    });
                } else {
                    // For PDF and Excel, show success message
                    Swal.fire({
                        title: 'Export Complete!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Download',
                        confirmButtonColor: '#8FCFA8',
                        showCancelButton: true,
                        cancelButtonText: 'Close'
                    }).then((result) => {
                        if (result.isConfirmed && response.download_url) {
                            window.open(response.download_url, '_blank');
                        }
                    });
                }
            } else {
                Swal.fire({
                    title: 'Export Failed',
                    text: response.message || 'Failed to generate report.',
                    icon: 'error',
                    confirmButtonColor: '#F16E70'
                });
            }
        },
        error: function(xhr, status, error) {
            let errorMessage = 'Failed to generate report.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 419) {
                errorMessage = 'Session expired. Please refresh the page and try again.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again later.';
            }
            
            Swal.fire({
                title: 'Export Failed',
                text: errorMessage,
                icon: 'error',
                confirmButtonColor: '#F16E70'
            });
        }
    });
}

function printReport() {
    window.print();
}
</script>
@endpush 