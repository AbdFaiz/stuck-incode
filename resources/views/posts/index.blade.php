@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-semibold">All Questions</h2>
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

                    <div class="row mb-2">
                        <div class="col">
                            <a href="{{ route('posts.show', $post->id) }}"
                                class="h5 text-decoration-none d-block mt-2">{{ $post->title }}</a>
                            <small class="text-muted">
                                Tags:
                                @foreach ($post->tags as $tag)
                                    <span class="badge bg-light text-dark">{{ $tag->name }}</span>
                                @endforeach
                            </small>
                        </div>
                        <div class="col text-end">
                            @if (auth()->user()->savedPosts->contains($post->id))
                                <form action="{{ route('posts.unsave', $post->id) }}" method="POST"
                                    style="display:inline;">
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

                            {{-- Dropdown untuk Edit dan Delete --}}
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

                                        <hr class="my-2 px-1">

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
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
