@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-9">
                <!-- Post Title and Details -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="mb-0">{{ $post->title }}</h2>
                            <div>
                                <span class="badge bg-info me-2">{{ $post->answers->count() }} answers</span>
                                <span class="badge bg-success">{{ $post->views }} views</span>
                            </div>
                        </div>
                        <p class="mb-4">{{ $post->details }}</p>
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
