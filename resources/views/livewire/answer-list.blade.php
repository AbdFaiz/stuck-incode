<div>
    @foreach ($post->answers as $answer)
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <!-- Voting untuk jawaban -->
                    @livewire('vote-button', ['answer' => $answer], key($answer->id))

                    <!-- Tombol mark as accepted jika user adalah pemilik post -->
                    @if (Auth::user()->id === $post->user_id)
                        @livewire('mark-answer-as-accepted', ['post' => $post, 'answer' => $answer], key('mark-answer-' . $answer->id))
                    @endif
                </div>

                <!-- Teks jawaban -->
                <p class="answer-content mb-3">{{ $answer->content }}</p>

                <!-- Status accepted -->
                @if ($answer->is_accepted)
                    <span class="badge bg-success"><i class="bi bi-check"></i> Accepted</span>
                @endif
            </div>
        </div>
    @endforeach
</div>

