@extends('layouts.app')

@section('content')
    <div class="container mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold">All Questions</h2>
            <div>
                <a href="{{ route('posts.create') }}" class="btn btn-primary me-3">Ask Question</a>
            </div>
        </div>

        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ request('filter') === 'newest' || !request('filter') ? 'active' : '' }}"
                    href="{{ route('posts.index', ['filter' => 'newest']) }}">
                    Newest
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') === 'votes' ? 'active' : '' }}"
                    href="{{ route('posts.index', ['filter' => 'votes']) }}">
                    Highest Votes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') === 'views' ? 'active' : '' }}"
                    href="{{ route('posts.index', ['filter' => 'views']) }}">
                    Most Viewed
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('filter') === 'unanswered' ? 'active' : '' }}"
                    href="{{ route('posts.index', ['filter' => 'unanswered']) }}">
                    Unanswered
                </a>
            </li>
        </ul>

        <!-- Questions list -->
        @foreach ($posts as $post)
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

                            @if (auth()->check() && auth()->user()->id === $post->user_id)
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">
                                                Edit
                                            </a>
                                        </li>

                                        <hr class="my-1 px-1">

                                        <li>
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item"
                                                    onclick="return confirm('Are you sure you want to delete this post?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr class="me-20 mb-2">

                    <!-- Short details -->
                    <p class="text-muted small mb-1">{{ Str::limit($post->details, 120) }}</p>

                    <!-- Tags and Ask Time -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @foreach ($post->tags as $tag)
                                <span class="badge bg-secondary text-light me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>

                        <div class="text-muted small">
                            Asked <span class="fw-semibold">{{ $post->created_at->diffForHumans() }}</span> by
                            <a href="{{ route('users.show', $post->user->id) }}"
                                class="fw-semibold fst-italic text-muted text-decoration-none">{{ $post->user->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
