<div>
    <h4 class="fw-thin">Your Answer</h4>
    <form wire:submit.prevent="addAnswer">
        <div class="mb-3">
            <textarea wire:model="content" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
