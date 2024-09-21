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
                <div class="col-md-3 mb-4 user-card">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="{{ route('users.show', $user->id) }}"
                                    class="text-decoration-none">{{ $user->name }}</a>
                            </h5>
                            <p class="card-text text-muted">{{ $user->email }}</p>
                            <p class="text-small">
                                <span><strong>{{ $user->posts_count }}</strong> posts</span> &bull;
                                <span><strong>{{ $user->answers_count }}</strong> answers</span>
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
                            var userCard =
                                `
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
                                            Joined ${user.created_at}
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
