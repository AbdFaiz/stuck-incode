@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row my-4 align-items-start">
        <div class="col-12">
            <!-- Header with margin-bottom for spacing -->
            <h2 class="fw-semibold mb-3">Tags</h2> <!-- Tambahkan 'mb-3' untuk memberi jarak bawah -->

            <!-- Informational message below the title with margin-top -->
            <p class="text-muted mb-4 mt-2" style="font-size: 16px;">
                A tag is a keyword or label that categorizes your question with other, similar questions.
                Using the right tags makes it easier for others to find and answer your question.
            </p>

            <!-- Filter input and buttons (Popular, Name, New) in the same line -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Filter input -->
                <div style="max-width: 300px;">
                    <input type="text" id="search-input" class="form-control" placeholder="Filter by tag name">
                </div>

                <!-- Buttons for sorting -->
                <div>
                    <button class="btn btn-outline-secondary btn-sm me-2">Popular</button>
                    <button class="btn btn-outline-secondary btn-sm me-2">Name</button>
                    <button class="btn btn-outline-secondary btn-sm">New</button>
                </div>
            </div>

            <!-- Alert for session status -->
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <!-- Tags list -->
            <div class="row row-cols-1 row-cols-md-3 g-4" id="tags-list">
                @foreach ($tags as $tag)
                <div class="col mb-4">
                    <div class="card w-100 h-auto border-0 shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <!-- Small badge for the tag name -->
                                <span class="badge bg-secondary text-black" style="font-size: 15px fw-semibold;">Laravel</span>
                            </div>
                            <p class="text-muted" style="font-size: 14px;">
                                Laravel is a web application framework with expressive, elegant syntax. It's designed for development speed and simplicity.
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- jQuery for AJAX search -->
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
                        var tagCard = `
                                <div class="col mb-4">
                                    <div class="card w-100 h-auto border-0 shadow-sm" style="background-color: #f8f9fa; border-radius: 8px;">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <a href="#" class="card-title mb-0 fw-bold" style="font-size: 16px; text-decoration: none; color: #000;">` + tag.name + `</a>
                                            </div>
                                            <p class="text-muted" style="font-size: 14px;">` + (tag.used_count || '0') + ` questions use this tag</p>
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