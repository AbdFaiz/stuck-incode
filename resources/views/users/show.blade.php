@extends('layouts.app')

@section('content')
    {{-- <pre>{{ print_r($user->toArray()) }}</pre> --}}

    <div class="container mb-4">
        <div class="row">
            <!-- Profil Header -->
            <div class="col-md-12 text-center mb-4 border-bottom pb-4">
                <div class="d-flex justify-content-center">
                    @if ($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="User Avatar"
                            style="height: 15rem; width: 15rem;" class="rounded-circle">
                    @else
                        <div class="d-flex align-items-center justify-content-center rounded-circle bg-secondary text-white"
                            style="height: 15rem; width: 15rem; font-size: 5rem;">
                            {{ strtoupper($user->name[0]) }}
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-center align-items-center">
                    <h1 class="fw-bold">{{ $user->name }}</h1>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-warning ms-2"><i
                            class="bi bi-pen"></i></a>
                </div>
                <p class="text-muted">{{ $user->email }} - {{ $user->location ?? 'Location' }}</p>
                <div class="mb-2">
                    <a href="#" class="text-decoration-none me-2">Twitter</a>
                    <a href="#" class="text-decoration-none me-2">GitHub</a>
                    <a href="#" class="text-decoration-none">Website</a>
                </div>
                <p class="text-muted">{{ $user->bio }}</p>
            </div>

            <!-- Stats -->
            <div class="col-md-12 text-center mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h6 class="text-primary fw-semibold">Reputation</h6>
                            <p class="display-6">{{ number_format($totalVotes) }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h6 class="text-success fw-semibold">Reached</h6>
                            <p class="display-6">{{ number_format($reached) }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h6 class="text-info fw-semibold">Answers</h6>
                            <p class="display-6">{{ number_format($user->answers_count) }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card p-3 shadow-sm border-light">
                            <h6 class="text-warning fw-semibold">Questions</h6>
                            <p class="display-6">{{ number_format($user->posts_count) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Badges -->
            <div class="col-md-12 mb-4">
                <h2 class="fw-semibold">Badges</h2>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm border-light text-center">
                            <h6 class="text-warning fw-semibold">Gold Badges</h6>
                            <p class="display-6">{{ $user->gold_badges }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm border-light text-center">
                            <h6 class="text-muted fw-semibold">Silver Badges</h6>
                            <p class="display-6">{{ $user->silver_badges }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 shadow-sm border-light text-center">
                            <h6 style="color:brown;" class="fw-semibold">Bronze Badges</h6>
                            <p class="display-6">{{ $user->bronze_badges }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- @dd($user) --}}

            <!-- Recent Posts -->
            <div class="col-md-12 mb-4">
                <h2 class="fw-semibold">Recent Posts</h2>
                <ul class="list-unstyled">
                    @forelse ($user->posts as $post)
                        <li class="mb-2 border rounded p-3 shadow-sm">
                            <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                                <h5>{{ $post->title }}</h5>
                            </a>
                            <p class="text-muted">{{ Str::limit($post->details, 100) }}</p>
                            <small class="text-muted">Votes: {{ $post->votes }}</small> <!-- Menampilkan jumlah votes -->
                            <small class="text-muted">Created {{ $post->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="text-muted">Tidak ada postingan terbaru.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Recent Answers -->
            <div class="col-md-12 mb-4">
                <h2 class="fw-semibold">Recent Answers</h2>
                <ul class="list-unstyled">
                    @forelse ($user->answers as $answer)
                        <li class="mb-2 border rounded p-3 shadow-sm">
                            Answered on
                            <a href="{{ route('posts.show', $answer->post->id) }}" class="text-decoration-none text-dark">
                                <h5>{{ $answer->post->title }}</h5>
                            </a>
                            <p class="text-muted">Votes: {{ $answer->votes }}</p> <!-- Menampilkan jumlah votes -->
                            <small class="text-muted">Answered {{ $answer->created_at->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="text-muted">Tidak ada jawaban terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
