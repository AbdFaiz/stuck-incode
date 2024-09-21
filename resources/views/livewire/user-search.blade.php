<div>
    <input type="text" wire:model="search" placeholder="Cari pengguna..." class="form-control">

    <ul class="list-group mt-3">
        @foreach ($users as $user)
            <li class="list-group-item">
                <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
