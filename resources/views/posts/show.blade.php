@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ $post->title }}</h2>
            <div>
                <span class="badge bg-info me-2">{{ $post->answers->count() }} answers</span>
                <span class="badge bg-success">{{ $post->views }} views</span>
                @livewire('post-vote-button', ['post' => $post], key($post->id)) <!-- Voting untuk post -->
            </div>
        </div>

        <div class="mb-3">
            <p>{{ $post->details }}</p>
        </div>

        <h3>Answers</h3>

        @livewire('add-answer', ['post' => $post], key($post->id)) <!-- Form Livewire untuk menambah jawaban -->

        @foreach ($post->answers as $answer)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            @livewire('vote-button', ['answer' => $answer], key($answer->id)) <!-- Voting untuk jawaban -->
                        </div>
                        @if (Auth::user()->id === $post->user_id)
                            @livewire('mark-answer-as-accepted', ['post' => $post, 'answer' => $answer], key('mark-answer-' . $answer->id))
                        @endif
                    </div>
                    <p>{{ $answer->content }}</p>
                    @if ($answer->is_accepted)
                        <span class="badge bg-success">✔️ Accepted</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
