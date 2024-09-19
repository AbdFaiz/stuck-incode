@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>All Questions</h2>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Ask Question</a>
        </div>

        <!-- Questions list -->
        <div class="list-group">
            @foreach ($posts as $post)
                <div class="list-group-item list-group-item-action mb-2 p-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between">
                        <div class="question-meta">
                            <span class="badge bg-secondary me-2">{{ $post->votes }} votes</span>
                            <span class="badge bg-info me-2">{{ $post->answers_count }} answers</span>
                            <span class="badge bg-success">{{ $post->views }} views</span>
                        </div>
                        <div class="question-time">
                            <small>asked {{ $post->created_at->diffForHumans() }} by {{ $post->user->name }}</small>
                        </div>
                    </div>
                    <a href="{{ route('posts.show', $post->id) }}"
                        class="h5 text-decoration-none d-block mt-2">{{ $post->title }}</a>
                    <small class="text-muted">
                        Tags:
                        @foreach ($post->tags as $tag)
                            <span class="badge bg-light text-dark">{{ $tag->name }}</span>
                        @endforeach
                    </small>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
