@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="fw-bold">{{ $user->name }}</h1>
            <p class="text-muted">{{ $user->email }}</p>
        </div>

        <div class="profile-stats mb-4">
            <h3 class="fw-bold">Profile Stats</h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h5>Posts</h5>
                        <p class="display-4">{{ $user->posts->count() }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h5>Answers</h5>
                        <p class="display-4">{{ $user->answers->count() }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h5>Reputation</h5>
                        <p class="display-4">{{ $user->posts->sum('reputation') }}</p>
                        <!-- Ganti sesuai logika reputasi jika ada -->
                    </div>
                </div>
            </div>
        </div>

        <h3 class="fw-bold">Recent Posts</h3>
        <ul class="list-unstyled">
            @foreach ($user->posts as $post)
                <li class="mb-2">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">{{ $post->title }}</a>
                </li>
            @endforeach
        </ul>

        <h3 class="fw-bold">Recent Answers</h3>
        <ul class="list-unstyled">
            @foreach ($user->answers as $answer)
                <li class="mb-2">
                    Answered on <a href="{{ route('posts.show', $answer->post->id) }}"
                        class="text-decoration-none">{{ $answer->post->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
