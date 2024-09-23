@extends('layouts.app')

@section('title', 'Edit Post - stackInCode')

@section('content')
    <div class="section-header mb-4">
        <h2 class="fw-semibold fs-4">Edit Your Question</h2>
    </div>

    <div class="row">
        <!-- Left Instructions Column -->
        <div class="col-md-8">
            <!-- Instructions Section -->
            <section class="instruction-section mb-4 p-4 border bg-light">
                <h2 class="fw-semibold fs-4">Writing a Good Question</h2>
                <p>You're ready to edit your programming-related question and this form will help guide you through the
                    process.</p>
                <p>Looking to ask a non-programming question? See the topics <a href="#">here</a> to find a relevant
                    site.</p>

                <h3 class="fw-semibold fs-4">Steps</h3>
                <ol>
                    <li>Summarize your problem in a one-line title.</li>
                    <li>Describe your problem in more detail.</li>
                    <li>Describe what you tried and what you expected to happen.</li>
                    <li>Add “tags” which help surface your question to members of the community.</li>
                    <li>Review your question and post it to the site.</li>
                </ol>
            </section>

            <!-- Form Section -->
            <form method="POST" action="{{ route('posts.update', $post->id) }}">
                @csrf
                @method('PUT')

                <div class="form-section mb-4">
                    <label for="title" class="form-label fw-semibold fs-5">Title</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="{{ old('title', $post->title) }}"
                        placeholder="e.g. Is there an R function for finding the index of an element in a vector?" required>
                </div>

                <div class="form-section mb-4">
                    <label for="details" class="form-label fw-semibold fs-5">What are the details of your problem?</label>
                    <textarea class="form-control" id="details" name="details" rows="5"
                        placeholder="Introduce the problem and expand on what you put in the title." required>{{ old('details', $post->details) }}</textarea>
                </div>

                <div class="form-section mb-4">
                    <label for="try_and_expect" class="form-label fw-semibold fs-5">What did you try and what were you
                        expecting?</label>
                    <textarea class="form-control" id="try_and_expect" name="try_and_expect" rows="5"
                        placeholder="Describe what you tried, what you expected to get, and what actually happened." required>{{ old('try_and_expect', $post->try_and_expect) }}</textarea>
                </div>

                <div class="form-section mb-4">
                    <label for="tags" class="form-label fw-semibold fs-5">Tags</label>
                    <input type="text" class="form-control" id="tags" name="tags[]"
                        placeholder="e.g. PHP, Laravel">
                    <div id="tag-suggestions" class="mt-2 bg-light border"></div>
                    <div id="tag-container" class="mt-2">
                        @foreach ($post->tags as $tag)
                            <div class="badge bg-secondary me-2 tag-item">
                                {{ $tag->name }}
                                <button class="btn-close ms-2" aria-label="Remove tag"
                                    onclick="removeTag(this, '{{ $tag->name }}')"></button>
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="tags-hidden" name="tags-hidden"
                        value="{{ implode(',', $post->tags->pluck('name')->toArray()) }}">
                </div>

                <button type="submit" class="btn btn-outline-primary mt-2">Update</button>
            </form>
        </div>

        <!-- Right Panel (Tips on writing a good title) -->
        <div class="col-md-4">
            <div class="bg-light p-3 border">
                <h2 class="fw-semibold fs-4">Writing a good title</h2>
                <p>Your title should summarize the problem.</p>
                <p>You might find that you have a better idea of your title after writing out the rest of the question.</p>
            </div>
        </div>
    </div>

    <!-- JavaScript Section to Control Tag Suggestions -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tagsInput = document.getElementById('tags');
            const tagContainer = document.getElementById('tag-container');
            const tagSuggestions = document.getElementById('tag-suggestions');
            let tagsArray = @json($post->tags->pluck('name'));

            const removeButton = document.createElement('button');
            removeButton.classList.add('btn-close', 'ms-2');
            removeButton.setAttribute('type', 'button');
            removeButton.setAttribute('aria-label', 'Remove tag');
            removeButton.addEventListener('click', function() {
                tagsArray = tagsArray.filter(t => t !== tag);
                tagContainer.removeChild(tagElement);
                updateTagsHidden();
            });


            // Function to update hidden input
            function updateTagsHidden() {
                document.getElementById('tags-hidden').value = tagsArray.join(',');
            }

            // Function to add tag
            function addTag(tag) {
                if (!tagsArray.includes(tag)) {
                    tagsArray.push(tag);

                    const tagElement = document.createElement('div');
                    tagElement.classList.add('badge', 'bg-secondary', 'me-2', 'tag-item');
                    tagElement.textContent = tag;

                    const removeButton = document.createElement('button');
                    removeButton.classList.add('btn-close', 'ms-2');
                    removeButton.setAttribute('aria-label', 'Remove tag');
                    removeButton.addEventListener('click', function() {
                        tagsArray = tagsArray.filter(t => t !== tag);
                        tagContainer.removeChild(tagElement);
                        updateTagsHidden();
                    });

                    tagElement.appendChild(removeButton);
                    tagContainer.appendChild(tagElement);
                    tagsInput.value = ''; // Clear input
                    tagSuggestions.innerHTML = ''; // Clear suggestions
                    updateTagsHidden();
                }
            }

            // Load existing tags into the tag container
            tagsArray.forEach(tag => {
                addTag(tag);
            });

            tagsInput.addEventListener('input', async function() {
                const query = tagsInput.value.trim();
                if (query.length > 1) {
                    const response = await fetch(/api/tags?query=${query});
                    const tags = await response.json();

                    tagSuggestions.innerHTML = tags.map(tag =>
                        <div class="suggestion-item p-2" data-tag="${tag.name}">${tag.name}</div>
                    ).join('');
                    tagSuggestions.style.display = 'block';
                } else {
                    tagSuggestions.innerHTML = '';
                    tagSuggestions.style.display = 'none';
                }
            });

            tagSuggestions.addEventListener('click', function(event) {
                if (event.target.classList.contains('suggestion-item')) {
                    addTag(event.target.dataset.tag);
                    tagSuggestions.style.display = 'none'; // Hide suggestions after selection
                }
            });

            tagsInput.addEventListener('keydown', function(event) {
                // Allow adding a new tag with "Enter" if it doesn't exist in suggestions
                if (event.key === 'Enter') {
                    const tagToAdd = tagsInput.value.trim();
                    if (tagToAdd !== '') {
                        addTag(tagToAdd);
                        event.preventDefault();
                    }
                }
            });
        });

        function removeTag(button, tag) {
            const tagContainer = document.getElementById('tag-container');
            const tagElement = button.parentElement;
            tagsArray = tagsArray.filter(t => t !== tag);
            tagContainer.removeChild(tagElement);
            updateTagsHidden();
        }
    </script>

@endsection
