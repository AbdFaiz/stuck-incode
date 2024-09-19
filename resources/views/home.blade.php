@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Top Questions</h2>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Ask Question</a>
        </div>

        <!-- Filter Navigation -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ $filter == 'interesting' ? 'active' : '' }}"
                    href="{{ route('home', ['filter' => 'interesting']) }}">Interesting</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $filter == 'week' ? 'active' : '' }}"
                    href="{{ route('home', ['filter' => 'week']) }}">This Week</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $filter == 'month' ? 'active' : '' }}"
                    href="{{ route('home', ['filter' => 'month']) }}">This Month</a>
            </li>
        </ul>

        <!-- Questions list -->
        @foreach ($topPosts as $post)
            <div class="row mb-4 pb-4 border-bottom">
                <!-- Votes, Answers, Views column -->
                <div class="col-md-2 text-center">
                    <div class="mb-2">
                        <span class="badge bg-primary text-small">{{ $post->votes }} votes</span><br>
                    </div>
                    <div class="mb-2">
                        <span class="badge {{ $post->answers_count > 0 ? 'bg-secondary' : 'bg-danger' }} text-small">
                            {{ $post->answers_count }} answer
                        </span><br>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-info text-small">{{ $post->views }} views</span><br>
                    </div>

                    <!-- Accepted Answer Indicator -->
                    @if ($post->answers->contains('is_accepted', true))
                        <div class="mt-2">
                            <span class="badge bg-success"><i class="bi bi-check"></i> Accepted Answer</span>
                        </div>
                    @endif
                </div>

                <!-- Question content -->
                <div class="col-md-10">
                    <h5 class="mb-2">
                        <a href="{{ route('posts.show', $post->id) }}"
                            class="text-decoration-none">{{ $post->title }}</a>
                    </h5>
                    <p class="text-muted">{{ Str::limit($post->content, 150) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Tags -->
                        <div>
                            @foreach ($post->tags as $tag)
                                <span class="badge bg-light text-dark me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <!-- Time and User Info -->
                        <small class="text-muted">asked {{ $post->created_at->diffForHumans() }} by
                            {{ $post->user->name }}</small>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $topPosts->links() }}
        </div>
    </div>
@endsection
