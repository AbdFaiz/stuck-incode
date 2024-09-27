<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="updateAnswer">
        <div class="mb-3">
            <label for="answerContent" class="form-label">Edit Answer</label>
            <textarea wire:model="content" class="form-control" id="answerContent" rows="4"></textarea>
            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-pencil-square"></i> Update
        </button>
    </form>
</div>
