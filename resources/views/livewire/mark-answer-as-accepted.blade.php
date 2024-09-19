<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <button wire:click="markAsAccepted" class="btn btn-outline-success btn-sm"
        {{ $answer->is_accepted ? 'disabled' : '' }}>
        {{ $answer->is_accepted ? 'Accepted' : 'Accept' }}
    </button>
</div>
