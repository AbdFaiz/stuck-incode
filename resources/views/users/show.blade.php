@extends('layouts.app')

@section('content')
    <div class="container mb-4">
        <div class="row">
            <!-- Profil Header -->
            <div class="col-md-12 text-center mb-4">
                <img src="path-to-avatar" class="rounded-circle mb-3" width="150" alt="{{ $user->name }}">
                <h1 class="fw-bold">{{ $user->name }}</h1>
                <p class="text-muted">{{ $user->email }} - {{ $user->location ?? 'Location' }}</p>
                <div>
                    <a href="#" class="text-decoration-none me-2">Twitter</a>
                    <a href="#" class="text-decoration-none me-2">GitHub</a>
                    <a href="#" class="text-decoration-none">Website</a>
                </div>
            </div>

            <!-- Stats -->
            <div class="col-md-12 text-center mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h5 class="text-primary">Reputation</h5>
                            <p class="display-6">{{ number_format($user->reputation) }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h5 class="text-success">Reached</h5>
                            <p class="display-6">{{ number_format($user->reached) }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h5 class="text-info">Answers</h5>
                            <p class="display-6">{{number_format($user->answers_count) }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h5 class="text-warning">Questions</h5>
                            <p class="display-6">{{ number_format($user->posts_count) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Badges -->
            <div class="col-md-12 mb-4">
                <h2 class="fw-semibold">Badges</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm border-light text-center">
                            <h5>Gold Badges</h5>
                            <p class="display-6">{{ $user->gold_badges }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm border-light text-center">
                            <h5>Silver Badges</h5>
                            <p class="display-6">{{ $user->silver_badges }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm border-light text-center">
                            <h5>Bronze Badges</h5>
                            <p class="display-6">{{ $user->bronze_badges }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div class="col-md-12 mb-4">
                <h2 class="fw-semibold">Recent Posts</h2>
                <ul class="list-unstyled">
                    @forelse ($user->posts as $post)
                        <li class="mb-2 border rounded p-3">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                                <h5>{{ $post->title }}</h5>
                            </a>
                            <p class="text-muted">{{ Str::limit($post->content, 100) }}</p>
                            <small class="text-muted">Created {{ $post->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li>Tidak ada postingan terbaru.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Recent Answers -->
            <div class="col-md-12 mb-4">
                <h2 class="fw-semibold">Recent Answers</h2>
                <ul class="list-unstyled">
                    @forelse ($user->answers as $answer)
                        <li class="mb-2 border rounded p-3">
                            Answered on 
                            <a href="{{ route('posts.show', $answer->post->id) }}" class="text-decoration-none text-dark">
                                <h5>{{ $answer->post->title }}</h5>
                            </a>
                            <small class="text-muted">Answered {{ $answer->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li>Tidak ada jawaban terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
