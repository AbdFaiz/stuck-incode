@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-9">
                <!-- Post Title and Details -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-1">{{ $post->title }}</h2>
                                <p class="text-muted mb-1 fst-italic">
                                    Asked {{ $post->created_at->diffForHumans() }} by
                                    <a href="{{ route('users.show', $post->user->id) }}"
                                        class="text-decoration-none text-muted fw-semibold">
                                        {{ $post->user->name }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <span class="badge bg-info me-2">{{ $post->answers->count() }} answers</span>
                                <span class="badge bg-success">{{ $post->views }} views</span>
                            </div>
                        </div>

                        <hr class="my-2">

                        <p class="mb-2">{{ $post->details }}</p>

                        <!-- Tags Section -->
                        <div class="mb-3">
                            @foreach ($post->tags as $tag)
                                <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                            @endforeach
                        </div>

                        <!-- Voting Button for the Post -->
                        @livewire('post-vote-button', ['post' => $post], key($post->id))
                    </div>
                </div>



                <!-- Answers Section -->
                <div class="mb-4">
                    @livewire('add-answer', ['post' => $post], key($post->id))
                </div>

                @livewire('answer-list', ['post' => $post], key('answer-list-' . $post->id))
            </div>
            <div class="col-lg-3">
                <!-- Right Sidebar (like Stack Overflow) -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5>Post Stats</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Views:</strong> {{ $post->views }}</p>
                        <p><strong>Answers:</strong> {{ $post->answers->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
