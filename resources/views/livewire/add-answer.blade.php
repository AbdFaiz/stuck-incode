<div>
    <h3>Add an Answer</h3>
    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <textarea wire:model="content" class="form-control" rows="3" required></textarea>
            @error('content')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
