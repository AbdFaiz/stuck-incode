<div class="card mb-4">
    <div class="card-body">
        <h4 class="card-title mb-3">Add an Answer</h4>
        <form wire:submit.prevent="addAnswer">
            <div class="mb-3">
                <textarea wire:model="content" class="form-control" rows="4" placeholder="Type your answer here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Answer</button>
        </form>
    </div>
</div>