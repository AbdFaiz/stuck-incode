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

        @livewire('answer-list', ['post' => $post], key('answer-list-' . $post->id)) <!-- Daftar jawaban -->
    </div>
@endsection
    