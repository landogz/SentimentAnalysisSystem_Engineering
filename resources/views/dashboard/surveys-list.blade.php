<div class="table-responsive">
    <table class="table modern-table">
        <thead>
            <tr>
                <th>Program</th>
                <th>Subject</th>
                <th>Rating</th>
                <th>Sentiment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($surveys as $survey)
                <tr class="survey-row" data-survey-id="{{ $survey->id }}" style="cursor: pointer;">
                    <td>
                        <strong style="color: #494850;">{{ $survey->subject->program ? 'BS ' . $survey->subject->program : 'N/A' }}</strong>
                    </td>
                    <td>
                        <strong style="color: #494850;">{{ $survey->subject->name ?? 'N/A' }}</strong>
                        @if($survey->subject && $survey->subject->subject_code)
                            <br>
                            <small class="text-muted">{{ $survey->subject->subject_code }}</small>
                        @endif
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
                        <br>
                        <small class="text-muted">{{ $survey->created_at->format('h:i A') }}</small>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary view-survey-btn" data-survey-id="{{ $survey->id }}" style="border-radius: 8px;">
                            <i class="fas fa-eye me-1"></i>View
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No surveys found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($surveys->hasPages())
<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Surveys pagination">
        <ul class="pagination">
            @if($surveys->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $surveys->previousPageUrl() }}" data-page="{{ $surveys->currentPage() - 1 }}">Previous</a>
                </li>
            @endif

            @php
                $currentPage = $surveys->currentPage();
                $lastPage = $surveys->lastPage();
                $startPage = max(1, $currentPage - 2);
                $endPage = min($lastPage, $currentPage + 2);
            @endphp

            @if($startPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $surveys->url(1) }}" data-page="1">1</a>
                </li>
                @if($startPage > 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
            @endif

            @for($page = $startPage; $page <= $endPage; $page++)
                @if($page == $surveys->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $surveys->url($page) }}" data-page="{{ $page }}">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            @if($endPage < $lastPage)
                @if($endPage < $lastPage - 1)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $surveys->url($lastPage) }}" data-page="{{ $lastPage }}">{{ $lastPage }}</a>
                </li>
            @endif

            @if($surveys->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $surveys->nextPageUrl() }}" data-page="{{ $surveys->currentPage() + 1 }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif

<script>
$(document).ready(function() {
    // Handle pagination clicks
    $(document).on('click', '#allSurveysContent .pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        
        $('#allSurveysContent').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3" style="color: #6c757d; font-weight: 500;">Loading surveys...</p>
            </div>
        `);
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $('#allSurveysContent').html(response);
                
                // Re-attach click handlers after pagination
                $(document).off('click', '#allSurveysContent .survey-row').on('click', '#allSurveysContent .survey-row', function(e) {
                    if ($(e.target).closest('.view-survey-btn').length || $(e.target).hasClass('view-survey-btn')) {
                        return;
                    }
                    const surveyId = $(this).data('survey-id');
                    if (typeof openSurveyResponsesModal === 'function') {
                        openSurveyResponsesModal(surveyId);
                    }
                });

                $(document).off('click', '#allSurveysContent .view-survey-btn').on('click', '#allSurveysContent .view-survey-btn', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const surveyId = $(this).data('survey-id');
                    if (surveyId && typeof openSurveyResponsesModal === 'function') {
                        openSurveyResponsesModal(surveyId);
                    }
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load surveys. Please try again.',
                    confirmButtonColor: '#F16E70'
                });
            }
        });
    });
});
</script>

