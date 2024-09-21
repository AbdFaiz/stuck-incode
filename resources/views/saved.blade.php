@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">All Saves</h2>
        </div>

        @if ($savedPosts->isEmpty())
            <div class="alert alert-info" role="alert">
                You haven't saved any posts yet.
            </div>
        @else
            <div class="list-group">
                @foreach ($savedPosts as $post)
                    <a href="{{ route('posts.show', $post->id) }}" class="list-group-item list-group-item-action mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">{{ $post->title }}</h5>
                            <p class="mb-1">{{ Str::limit($post->content, 150) }}</p>
                            <small class="text-muted">Saved on {{ $post->created_at->format('M d, Y') }}</small>
                        </div>
                        <span class="badge bg-secondary">{{ $post->category->name ?? 'Uncategorized' }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
