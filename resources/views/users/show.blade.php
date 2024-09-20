@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    
    <div class="profile-stats">
        <h3>Profile Stats</h3>
        <p>Questions: {{ $questions->count() }}</p>
        <p>Answers: {{ $answers->count() }}</p>
        <p>Reputation: {{ $user->reputation }}</p>
    </div>

    <h3>Recent Questions</h3>
    <ul>
        @foreach ($questions as $question)
            <li><a href="{{ route('questions.show', $question->id) }}">{{ $question->title }}</a></li>
        @endforeach
    </ul>

    <h3>Recent Answers</h3>
    <ul>
        @foreach ($answers as $answer)
            <li>Answered on <a href="{{ route('questions.show', $answer->question->id) }}">{{ $answer->question->title }}</a></li>
        @endforeach
    </ul>
</div>
@endsection
