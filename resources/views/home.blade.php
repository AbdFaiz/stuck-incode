@extends('layouts.app')

@section('content')
    <div class="container mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold">Top Questions</h4>
            <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary">Ask Question</a>
        </div>

        <!-- Filter Navigation -->
        <ul class="nav nav-pills mb-3">
            <li class="nav-item">
                <a class="nav-link py-1 px-3 {{ $filter == 'interesting' ? 'active' : '' }}"
                    href="{{ route('home', ['filter' => 'interesting']) }}">Interesting</a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-1 px-3 {{ $filter == 'week' ? 'active' : '' }}"
                    href="{{ route('home', ['filter' => 'week']) }}">This Week</a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-1 px-3 {{ $filter == 'month' ? 'active' : '' }}"
                    href="{{ route('home', ['filter' => 'month']) }}">This Month</a>
            </li>
        </ul>

        <!-- Questions list -->
        @foreach ($topPosts as $post)
            <div class="row mb-3 py-3 px-1 border-2 rounded position-relative">
                <!-- Votes, Answers, Views column -->
                <div class="col-md-2 text-end">
                    <div class="mb-0.5">
                        <span class="badge bg-primary text-small">{{ $post->votes }} votes</span>
                    </div>
                    <div class="mb-0.5">
                        <span class="badge {{ $post->answers_count > 0 ? 'bg-success' : 'bg-danger' }} text-small">
                            {{ $post->answers_count }} answers
                        </span>
                    </div>
                    <div class="mb-0.5">
                        <span class="badge bg-info text-small">{{ $post->views }} views</span>
                    </div>

                    <!-- Accepted Answer Indicator -->
                    @if ($post->answers->contains('is_accepted', true))
                        <div class="mt-1">
                            <span class="badge bg-success"><i class="bi bi-check-circle"></i></span>
                        </div>
                    @endif
                </div>

                <!-- Question content -->
                <div class="col-md-10">
                    <div class="d-flex justify-content-between">
                        <!-- Title with truncation -->
                        <a href="{{ route('posts.show', $post->id) }}"
                            class="text-decoration-none fw-semibold text-primary d-block text-truncate"
                            style="font-size: 1.1rem; max-width: calc(100% - 100px);">
                            {{ $post->title }}
                        </a>

                        <!-- Save button -->
                        <div class="mt-1">
                            @if (auth()->user()->savedPosts->contains($post->id))
                                <form action="{{ route('posts.unsave', $post->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-warning">
                                        <i class="fas fa-bookmark"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('posts.save', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="far fa-bookmark"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <hr class="me-20 mb-2">

                    <!-- Short details -->
                    <p class="text-muted small mb-1">{{ Str::limit($post->details, 120) }}</p>

                    <!-- Tags and Ask Time -->
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Tags -->
                        <div>
                            @foreach ($post->tags as $tag)
                                <span class="badge bg-secondary text-light me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>

                        <!-- Ask Time & User Info -->
                        <div class="text-muted small">
                            Asked {{ $post->created_at->diffForHumans() }} by
                            <a href="{{ route('users.show', $post->user->id) }}"
                                class="fw-semibold">{{ $post->user->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $topPosts->links() }}
        </div>
    </div>
@endsection
