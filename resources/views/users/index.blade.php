@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-bold mb-4">Users</h2>

    <!-- Livewire User Search -->
    <h3>Cari Pengguna</h3>
    @livewire('user-search')    

    <!-- Users List -->
    <div id="user-list" class="row">
        @foreach ($users as $user)
            <div class="col-md-3 mb-4 user-card">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('users.show', $user->id) }}" class="text-decoration-none">{{ $user->name }}</a>
                        </h5>
                        <p class="card-text text-muted">{{ $user->email }}</p>
                        <p class="text-small">
                            <span><strong>{{ $user->posts->count() }}</strong> posts</span> &bull;
                            <span><strong>{{ $user->answers->count() }}</strong> answers</span>
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        Joined {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $('#search').on('keyup', function() {
        let query = $(this).val();
        $.ajax({
            url: "{{ route('users.index') }}",  // Pastikan route ini sesuai
            type: "GET",
            data: { query: query },
            success: function(data) {
                $('#user-list').empty();
                if (data.length > 0) {
                    $.each(data, function(index, user) {
                        $('#user-list').append(`
                            <div class="col-md-3 mb-4 user-card">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="/users/${user.id}" class="text-decoration-none">${user.name}</a>
                                        </h5>
                                        <p class="card-text text-muted">${user.email}</p>
                                        <p class="text-small">
                                            <span><strong>${user.posts_count}</strong> posts</span> &bull;
                                            <span><strong>${user.answers_count}</strong> answers</span>
                                        </p>
                                    </div>
                                    <div class="card-footer text-muted">
                                        Joined ${new Date(user.created_at).toLocaleDateString()}
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    $('#user-list').append('<p>No users found</p>');
                }
            }
        });
    });
});
</script>
@endsection
@endsection