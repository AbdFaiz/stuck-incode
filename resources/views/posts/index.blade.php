@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">All Questions</h2>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Ask Question</a>
        </div>

        <!-- Questions list -->
        <div class="list-group">
            @foreach ($posts as $post)
                <div class="list-group-item list-group-item-action mb-3 p-4 border rounded shadow-sm">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="question-meta">
                            <span class="badge bg-secondary me-2">{{ $post->votes }} votes</span>
                            <span class="badge bg-info me-2">{{ $post->answers_count }} answers</span>
                            <span class="badge bg-success">{{ $post->views }} views</span>
                        </div>
                        <div class="question-time">
                            <small class="text-muted">asked {{ $post->created_at->diffForHumans() }} by
                                {{ $post->user->name }}</small>
                        </div>
                    </div>

                    {{-- Save --}}
                    <div class="text-end mb-2">
                        @if (auth()->user()->savedPosts->contains($post->id))
                            <form action="{{ route('posts.unsave', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-bookmark"></i>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('posts.save', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="far fa-bookmark"></i>
                                </button>
                            </form>
                        @endif
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
