@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ $post->title }}</h2>
            <div>
                <span class="badge bg-secondary me-2">{{ $post->votes }} votes</span>
                <span class="badge bg-info me-2">{{ $post->answers->count() }} answers</span>
                <span class="badge bg-success">{{ $post->views }} views</span>
                <!-- Button to upvote question -->
                <form method="POST" action="{{ route('posts.vote', $post->id) }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="vote" value="up">
                    <button type="submit" class="btn btn-outline-primary btn-sm">Upvote</button>
                </form>
                <!-- Button to downvote question -->
                <form method="POST" action="{{ route('posts.downvote', $post->id) }}" class="d-inline">
                    @csrf
                    <input type="hidden" name="vote" value="down">
                    <button type="submit" class="btn btn-outline-danger btn-sm">Downvote</button>
                </form>
            </div>
        </div>

        <div class="mb-3">
            <p>{{ $post->details }}</p>
        </div>

        <h3>Answers</h3>

        @foreach ($post->answers as $answer)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge bg-secondary me-2">{{ $answer->votes }} votes</span>
                            <!-- Button to upvote answer -->
                            <form method="POST" action="{{ route('answers.vote', $answer->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="vote" value="up">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Upvote</button>
                            </form>
                            <!-- Button to downvote answer -->
                            <form method="POST" action="{{ route('answers.vote', $answer->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="vote" value="down">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Downvote</button>
                            </form>
                        </div>
                        @if (Auth::user()->id === $post->user_id)
                            <!-- Button to mark answer as accepted -->
                            <form method="POST" action="{{ route('answers.markAsAccepted', $answer->id) }}"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm"
                                    {{ $answer->is_accepted ? 'disabled' : '' }}>Accept</button>
                            </form>
                        @endif
                    </div>
                    <p>{{ $answer->content }}</p>
                </div>
            </div>
        @endforeach

        <h3>Add an Answer</h3>
        <form method="POST" action="{{ route('answers.store', ['post' => $post->id]) }}">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>        
    </div>
@endsection
