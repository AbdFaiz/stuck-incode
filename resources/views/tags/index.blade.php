@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row my-4 align-items-start">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="me-3">
                        <h2 class="fw-bold">Tag</h2>
                    </div>
                    <div>
                        <input type="text" id="search-input" class="form-control" placeholder="Search tags...">
                    </div>
                </div>

                <!-- Alert for session status -->
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Tags list -->
                <div class="row" id="tags-list">
                    @foreach ($tags as $tag)
                        <div class="col-md-3 mb-4">
                            <div class="card border-dark h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <a href="#" class="card-title mb-0 fw-bold text-dark"
                                            style="text-decoration: none;">{{ $tag->name }}</a>
                                    </div>
                                    <p class="card-text mt-2">{{ $tag->used_count }} questions use this tag</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#search-input').on('keyup', function() {
                var query = $(this).val();

                $.ajax({
                    url: "{{ route('tags.index') }}",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(response) {
                        $('#tags-list').empty();

                        $.each(response, function(index, tag) {
                            var randomColors = ['primary', 'secondary', 'success',
                                'danger', 'warning', 'info', 'dark'
                            ];
                            var randomColor = randomColors[Math.floor(Math.random() *
                                randomColors.length)];

                            var tagCard = `
                            <div class="col-md-3 mb-4">
                                <div class="card border-` + randomColor + ` h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <a href="#" class="card-title mb-0 fw-bold text-` + randomColor +
                                `" style="text-decoration: none;">` + tag.name + `</a>
                                        </div>
                                        <p class="card-text mt-2">` + (tag.description || 'No description available') + `</p>
                                    </div>
                                </div>
                            </div>
                        `;

                            $('#tags-list').append(tagCard);
                        });
                    }
                });
            });
        });
    </script>
@endsection
