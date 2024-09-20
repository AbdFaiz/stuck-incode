@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="fw-bold mb-4">Saved Posts</h2>

        @if ($savedPosts->isEmpty())
            <div class="alert alert-info" role="alert">
                You haven't saved any posts yet.
            </div>
        @else
            <div class="list-group">
                @foreach ($savedPosts as $post)
                    <a href="{{ route('posts.show', $post->id) }}" class="list-group-item list-group-item-action mb-2">
                        <h5 class="mb-1">{{ $post->title }}</h5>
                        <p class="mb-1">{{ Str::limit($post->content, 150) }}</p>
                        <small class="text-muted">Saved on {{ $post->created_at->format('M d, Y') }}</small>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
