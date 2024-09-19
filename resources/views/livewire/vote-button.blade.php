<div>
    {{-- Do your work, then step back. --}}
    <button wire:click="upvote" class="btn btn-outline-primary btn-sm">Upvote</button>
    <button wire:click="downvote" class="btn btn-outline-danger btn-sm">Downvote</button>
    <span class="badge bg-secondary">{{ $votes }} votes</span>
</div>
