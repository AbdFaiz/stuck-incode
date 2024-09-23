@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fw-semibold mb-4">Users</h2>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div style="max-width: 300px;">
            <input type="text" id="search-input" class="form-control" placeholder="Search by user name or email">
        </div>
    </div>

    <!-- Users List -->
    <div id="user-list" class="row">
        @foreach ($users as $user)
        <div class="col-md-4 mb-4 user-card">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center">
                    <!-- Profile Image or Initials on the Left -->
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center bg-secondary text-white rounded-circle"
                        style="width: 2.5rem; height: 2.5rem; object-fit: cover;">
                        @if ($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <span style="font-size: 1rem;">{{ strtoupper($user->name[0]) }}</span>
                        @endif
                    </div>

                    <!-- User Information on the Right -->
                    <div class="ms-3">
                        <h6 class="card-title mb-0 text-truncate" style="max-width: 150px;">
                            <a href="{{ route('users.show', $user->id) }}" class="text-decoration-none">{{ $user->name }}</a>
                        </h6>
                        <!-- <small class="card-text text-muted text-truncate" style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ $user->email }}</small> -->
                        <small class="text-small text-truncate" style="max-width: 150px;">
                            <span><strong>{{ number_format($user->posts_count) }}</strong> posts</span> &bull;
                            <span><strong>{{ number_format($user->answers_count) }}</strong> answers</span>
                        </small>
                        <div class="text-muted text-truncate" style="max-width: 150px;">Joined {{ $user->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mb-4">
        {{ $users->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle search input
        $('#search-input').on('keyup', function() {
            var query = $(this).val();
            fetchUsers(query);
        });

        // Function to fetch and display users
        function fetchUsers(query) {
            $.ajax({
                url: "{{ route('users.index') }}",
                type: "GET",
                data: {
                    'search': query
                },
                success: function(response) {
                    $('#user-list').empty();
                    $.each(response.data, function(index, user) {
                        var imageHtml = user.image ?
                            `<img src="/storage/${user.image}" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">` :
                            `<div class="d-flex align-items-center justify-content-center bg-secondary text-white rounded-circle" style="width: 2.5rem; height: 2.5rem; font-size: 1rem;">${user.name[0].toUpperCase()}</div>`;

                        var userCard =
                            ` 
                            <div class="col-md-4 mb-4 user-card">
                                <div class="card h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            ${imageHtml}
                                        </div>
                                        <div class="ms-3">
                                            <h6 class="card-title mb-0 text-truncate" style="max-width: 150px;">
                                                <a href="/users/${user.id}" class="text-decoration-none text-dark">${user.name}</a>
                                            </h6>
                                            <small class="card-text text-muted text-truncate" style="max-width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">${user.email}</small>
                                            <small class="text-small text-truncate" style="max-width: 150px;">
                                                <span><strong>${user.posts_count}</strong> posts</span> &bull;
                                                <span><strong>${user.answers_count}</strong> answers</span>
                                            </small>
                                            <div class="text-muted text-truncate" style="max-width: 150px;">Joined ${user.created_at}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        $('#user-list').append(userCard);
                    });
                },
                error: function(xhr) {
                    console.error(xhr);
                }
            });
        }
    });
</script>
@endsection