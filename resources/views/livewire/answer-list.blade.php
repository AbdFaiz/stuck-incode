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

                <!-- Jika user adalah pemilik jawaban, tampilkan form edit -->
                @if (Auth::id() === $answer->user_id)
                    <form wire:submit.prevent="updateAnswer({{ $answer->id }})">
                        <div class="mb-3">
                            <label for="answerContent-{{ $answer->id }}" class="form-label">Edit Jawaban Anda</label>
                            <textarea wire:model="answers.{{ $answer->id }}" class="form-control" id="answerContent-{{ $answer->id }}" rows="4">{{ $answer->content }}</textarea>
                            @error('answers.' . $answer->id) <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <!-- Tombol Update -->
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i> Update
                            </button>
                            <!-- Tombol Delete -->
                            @livewire('delete-answer', ['answer' => $answer], key('delete-answer-' . $answer->id))
                        </div>
                    </form>
                @else
                    <!-- Teks jawaban jika bukan pemilik -->
                    <p class="answer-content mb-3">{{ $answer->content }}</p>

                    <!-- Status accepted -->
                    @if ($answer->is_accepted)
                        <span class="badge bg-success"><i class="bi bi-check"></i> Accepted</span>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
