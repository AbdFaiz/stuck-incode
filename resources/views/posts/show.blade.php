@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="fw-semibold">{{ $post->title }}</h2>
                <p class="text-muted">Asked {{ $post->created_at->diffForHumans() }} by <a
                        href="{{ route('users.show', $post->user->id) }}"
                        class="text-decoration-none text-muted fw-semibold">{{ $post->user->name }}</a></p>
            </div>
            <div>
                <span class="badge bg-info me-2">{{ $post->answers->count() }} answers</span>
                <span class="badge bg-success">{{ $post->views }} views</span>
                @livewire('post-vote-button', ['post' => $post], key($post->id))
            </div>
        </div>

        <div class="mb-8">
            <p class="fs-5">{{ $post->details }}</p>
            <p class="text-muted">{{ $post->try_and_expect }}</p>
        </div>

        <hr>

        @livewire('add-answer', ['post' => $post], key($post->id)) <!-- Form Livewire untuk menambah jawaban -->

        <div class="list-group mt-4">
            @foreach ($post->answers as $answer)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1">{{ $answer->user->name }}</h5>
                            <small class="text-muted">{{ $answer->created_at->diffForHumans() }}</small>
                        </div>
                        <div>
                            @livewire('vote-button', ['answer' => $answer], key($answer->id)) <!-- Voting untuk jawaban -->
                        </div>
                    </div>
                    <p class="mb-1">{{ $answer->details }}</p>
                    @if ($answer->accepted)
                        <span class="badge bg-warning">Accepted Answer</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
