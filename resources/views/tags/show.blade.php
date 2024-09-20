@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col-lg-8">
                <!-- Tag Title Section -->
                <h1 class="fw-bold">{{ $tag->name }}</h1>
                <p class="text-muted" style="font-size: 16px;">
                    Tags are keywords or labels that help categorize your questions with others that share similar topics. 
                    Use relevant tags to make it easier for others to find and answer your question.
                </p>

                <!-- Watch and Follow Buttons -->
                <div class="d-flex align-items-center mb-4">
                    <button class="btn btn-outline-primary me-3 px-4">Watch Tag</button>
                    <span class="text-muted"><strong>{{ $tag->used_count ?? 0 }}</strong> questions use this tag</span>
                </div>

                <!-- Tag Description -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Tag Information</h5>
                        <p class="card-text">{{ $tag->description ?? 'No description available for this tag.' }}</p>
                    </div>
                </div>

                <!-- Related Questions Section -->
                <div class="mb-4">
                    <h5 class="fw-semibold mb-3">Related Questions</h5>
                    @if ($questions->count())
                        @foreach ($questions as $question)
                            <div class="border-bottom mb-3 pb-3">
                                <h6 class="fw-semibold">
                                    <a href="{{ route('posts.show', $question->id) }}" class="text-decoration-none text-primary">{{ $question->title }}</a>
                                </h6>
                                <p class="text-muted" style="font-size: 14px;">{{ Str::limit($question->body, 100) }}</p>
                                <div class="d-flex align-items-center small">
                                    <span class="me-3"><i class="bi bi-chat-left-text"></i> {{ $question->answers_count }} answers</span>
                                    <span class="me-3"><i class="bi bi-hand-thumbs-up"></i> {{ $question->votes_count }} votes</span>
                                    <span class="text-muted"><i class="bi bi-clock"></i> {{ $question->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning" role="alert">
                            No questions related to this tag at the moment.
                        </div>
                    @endif
                </div>

                <!-- Pagination Links -->
                <div>
                    {{ $questions->links() }}
                </div>
            </div>

            <!-- Sidebar Section for Tag Stats -->
            <div class="col-lg-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">Tag Statistics</h5>
                        <ul class="list-unstyled">
                            <li><strong>{{ $tag->used_count ?? 0 }}</strong> questions</li>
                            <li>Created: <strong>{{ $tag->created_at->format('M d, Y') }}</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
