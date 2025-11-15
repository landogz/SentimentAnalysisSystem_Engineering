@extends('layouts.app')

@section('title', 'Sentiment Words Management')
@section('icon', 'brain')
@section('page-title', 'Sentiment Words Management')

@section('breadcrumb')
<li class="breadcrumb-item active">Sentiment Words</li>
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modern-card .card-header h4 {
        font-weight: 700;
        font-size: 1.3rem;
        color: #494850;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card .card-header .btn-modern {
        margin-left: auto;
    }

    .modern-card .card-body {
        padding: 2rem;
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

    /* Filter Panel */
    .filter-panel {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(152, 170, 231, 0.2);
    }

    .filter-panel .form-control,
    .filter-panel .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.2s ease;
    }

    .filter-panel .form-control:focus,
    .filter-panel .form-select:focus {
        border-color: #98AAE7;
        box-shadow: 0 0 0 0.2rem rgba(152, 170, 231, 0.25);
    }

    .btn-modern {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<div class="row">
    <!-- Statistics Cards -->
    @php
        $totalWords = \App\Models\SentimentWord::count();
        $positiveWords = \App\Models\SentimentWord::where('type', 'positive')->count();
        $negativeWords = \App\Models\SentimentWord::where('type', 'negative')->count();
        $neutralWords = \App\Models\SentimentWord::where('type', 'neutral')->count();
    @endphp
    <div class="col-lg-3 col-6">
        <div class="stat-card info">
            <div class="stat-icon">
                <i class="fas fa-brain"></i>
            </div>
            <div class="stat-value">{{ $totalWords }}</div>
            <div class="stat-label">Total Words</div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-thumbs-up"></i>
            </div>
            <div class="stat-value">{{ $positiveWords }}</div>
            <div class="stat-label">Positive Words</div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="stat-card danger">
            <div class="stat-icon">
                <i class="fas fa-thumbs-down"></i>
            </div>
            <div class="stat-value">{{ $negativeWords }}</div>
            <div class="stat-label">Negative Words</div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-minus-circle"></i>
            </div>
            <div class="stat-value">{{ $neutralWords }}</div>
            <div class="stat-label">Neutral Words</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="modern-card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-brain"></i>
                    Sentiment Words Management
                </h4>
                <a href="{{ route('sentiment-words.create') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-plus me-1"></i> Add New Word
                </a>
            </div>
            <div class="card-body">
                <!-- Search and Filters -->
                <form method="GET" action="{{ route('sentiment-words.index') }}" class="filter-panel">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search words..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                <option value="positive" {{ request('type') == 'positive' ? 'selected' : '' }}>Positive</option>
                                <option value="negative" {{ request('type') == 'negative' ? 'selected' : '' }}>Negative</option>
                                <option value="neutral" {{ request('type') == 'neutral' ? 'selected' : '' }}>Neutral</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="language" class="form-select">
                                <option value="">All Languages</option>
                                <option value="en" {{ request('language') == 'en' ? 'selected' : '' }}>English</option>
                                <option value="tl" {{ request('language') == 'tl' ? 'selected' : '' }}>Tagalog</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="active" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary btn-modern">
                                <i class="fas fa-search me-1"></i> Search & Filter
                            </button>
                            <a href="{{ route('sentiment-words.index') }}" class="btn btn-outline-secondary btn-modern">
                                <i class="fas fa-times me-1"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Search Results Info -->
                @if(request('search') || request('type') || request('language') || request('active'))
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-search"></i>
                        <strong>Search Results:</strong> 
                        Found {{ $words->total() }} word(s) 
                        @if(request('search'))
                            matching "{{ request('search') }}"
                        @endif
                        @if(request('type') || request('language') || request('active'))
                            with applied filters
                        @endif
                        <a href="{{ route('sentiment-words.index') }}" class="float-end">
                            <i class="fas fa-times"></i> Clear Search
                        </a>
                    </div>
                @endif



                <!-- Words Table -->
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Word</th>
                                <th>Negation</th>
                                <th>Type</th>
                                <th>Score</th>
                                <th>Language</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($words as $word)
                                <tr>
                                    <td>
                                        <strong>{{ $word->word }}</strong>
                                    </td>
                                    <td>
                                        @if($word->negation)
                                            <span class="badge bg-secondary">{{ $word->negation }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $word->type == 'positive' ? 'success' : ($word->type == 'negative' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($word->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $word->score > 0 ? 'success' : ($word->score < 0 ? 'danger' : 'warning') }}">
                                            {{ $word->score }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ strtoupper($word->language) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $word->is_active ? 'success' : 'danger' }}">
                                            {{ $word->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $word->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('sentiment-words.show', $word) }}" 
                                               class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sentiment-words.edit', $word) }}" 
                                               class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="deleteWord({{ $word->id }}, '{{ $word->word }}')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No sentiment words found</h5>
                                            <p class="text-muted">Start by adding your first sentiment word.</p>
                                            <a href="{{ route('sentiment-words.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add First Word
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($words->hasPages())
                    <div class="mt-3">
                        {{ $words->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Test Analysis Modal -->
<div class="modal fade" id="testAnalysisModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Sentiment Analysis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="testText" class="form-label">Text to Analyze</label>
                    <textarea class="form-control" id="testText" rows="3" placeholder="Enter text to analyze..."></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="testLanguage" class="form-label">Language</label>
                        <select class="form-select" id="testLanguage">
                            <option value="en">English</option>
                            <option value="tl">Tagalog</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="testTranslate">
                            <label class="form-check-label" for="testTranslate">
                                Translate to English for analysis
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" id="analyzeBtn">
                        <i class="fas fa-search"></i> Analyze
                    </button>
                </div>
                
                <div id="analysisResults" class="mt-4" style="display: none;">
                    <h6>Analysis Results:</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Sentiment:</strong> <span id="resultSentiment"></span></p>
                                    <p><strong>Score:</strong> <span id="resultScore"></span></p>
                                    <p><strong>Rating:</strong> <span id="resultRating"></span>/5</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Positive Score:</strong> <span id="resultPositive"></span></p>
                                    <p><strong>Negative Score:</strong> <span id="resultNegative"></span></p>
                                    <p><strong>Neutral Score:</strong> <span id="resultNeutral"></span></p>
                                </div>
                            </div>
                            <div id="translationInfo" style="display: none;">
                                <hr>
                                <p><strong>Original Text:</strong> <span id="originalText"></span></p>
                                <p><strong>Translated Text:</strong> <span id="translatedText"></span></p>
                            </div>
                            <div id="matchedWords" style="display: none;">
                                <hr>
                                <h6>Matched Words:</h6>
                                <div id="matchedWordsList"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the word "<strong id="deleteWordName"></strong>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Search functionality enhancements
    $('#searchInput').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            e.preventDefault();
            $(this).closest('form').submit();
        }
    });
    
    // Auto-submit form when search field changes (with debounce)
    let searchTimeout;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            $(this).closest('form').submit();
        }, 500); // 500ms delay
    });
    
    // Test analysis functionality
    $('#analyzeBtn').click(function() {
        const text = $('#testText').val();
        const language = $('#testLanguage').val();
        const translate = $('#testTranslate').is(':checked');
        
        if (!text.trim()) {
            Swal.fire('Error', 'Please enter text to analyze', 'error');
            return;
        }
        
        $.ajax({
            url: '{{ route("sentiment-words.test-analysis") }}',
            method: 'POST',
            data: {
                text: text,
                language: language,
                translate: translate
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    displayAnalysisResults(response.data);
                }
            },
            error: function() {
                Swal.fire('Error', 'Failed to analyze text', 'error');
            }
        });
    });
    
    // Display analysis results
    function displayAnalysisResults(data) {
        $('#resultSentiment').text(data.sentiment);
        $('#resultScore').text(data.score);
        $('#resultRating').text(data.rating);
        $('#resultPositive').text(data.positive_score);
        $('#resultNegative').text(data.negative_score);
        $('#resultNeutral').text(data.neutral_score);
        
        // Show translation info if available
        if (data.translation_success && data.translated_text) {
            $('#originalText').text(data.original_text);
            $('#translatedText').text(data.translated_text);
            $('#translationInfo').show();
        } else {
            $('#translationInfo').hide();
        }
        
        // Show matched words
        if (data.matched_words && data.matched_words.length > 0) {
            let matchedWordsHtml = '';
            data.matched_words.forEach(function(match) {
                const badgeClass = match.type === 'positive' ? 'success' : (match.type === 'negative' ? 'danger' : 'warning');
                matchedWordsHtml += `<span class="badge bg-${badgeClass} me-1 mb-1">${match.word} (${match.score})</span>`;
            });
            $('#matchedWordsList').html(matchedWordsHtml);
            $('#matchedWords').show();
        } else {
            $('#matchedWords').hide();
        }
        
        $('#analysisResults').show();
    }
});

function deleteWord(id, wordName) {
    $('#deleteWordName').text(wordName);
    $('#deleteForm').attr('action', `/sentiment-words/${id}`);
    $('#deleteModal').modal('show');
}

// Add floating action button for test analysis
$(document).ready(function() {
    $('body').append(`
        <div class="position-fixed" style="bottom: 20px; right: 20px; z-index: 1000;">
            <button class="btn btn-primary rounded-circle shadow-lg" style="width: 60px; height: 60px; border: none;" 
                    onclick="$('#testAnalysisModal').modal('show')" title="Test Analysis">
                <i class="fas fa-brain" style="font-size: 1.5rem;"></i>
            </button>
        </div>
    `);
});
</script>
@endpush 