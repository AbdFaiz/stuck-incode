<div>
    @foreach ($post->answers as $answer)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    @livewire('vote-button', ['answer' => $answer], key($answer->id)) <!-- Voting untuk jawaban -->
                    @if (Auth::user()->id === $post->user_id)
                        @livewire('mark-answer-as-accepted', ['post' => $post, 'answer' => $answer], key('mark-answer-' . $answer->id))
                    @endif
                </div>
                <p>{{ $answer->content }}</p>
                @if ($answer->is_accepted)
                    <span class="badge bg-success"><i class="bi bi-check"></i> Accepted</span>
                @endif
            </div>
        </div>
    @endforeach
</div>
