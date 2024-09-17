@extends('layouts.app')

@section('title', 'Ask a Question')

@section('content')
<div class="section-header">
    <h1 class="fw-bold fs-3">Ask a question</h1>
</div>

<form method="POST" action="{{ route('posts.store') }}">
    @csrf
    <div class="form-section">
        <div class="mb-3" id="section-title">
            <label for="title" class="form-label fw-bold">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Is there an R function for finding the index of an element in a vector?" required>
            <button type="button" class="btn btn-primary mt-2" id="next-details" disabled>Next</button>
        </div>
    </div>

    <div class="form-section mt-3" id="section-details">
        <div class="mb-3">
            <label for="details" class="form-label">What are the details of your problem?</label>
            <textarea class="form-control" id="details" name="details" rows="5" placeholder="Introduce the problem and expand on what you put in the title." required disabled></textarea>
            <button type="button" class="btn btn-primary mt-2" id="next-try-and-expect" disabled>Next</button>
        </div>
    </div>

    <div class="form-section mt-3" id="section-try-and-expect">
        <div class="mb-3">
            <label for="try_and_expect" class="form-label">What did you try and what were you expecting?</label>
            <textarea class="form-control" id="try_and_expect" name="try_and_expect" rows="5" placeholder="Describe what you tried, what you expected to get, and what actually happened." required disabled></textarea>
            <button type="submit" class="btn btn-primary mt-2" disabled>Submit</button>
        </div>
    </div>

</form>

<!-- JavaScript Section to Control Form Flow -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const titleInput = document.getElementById('title');
        const detailsInput = document.getElementById('details');
        const tryAndExpectInput = document.getElementById('try_and_expect');

        const nextDetailsBtn = document.getElementById('next-details');
        const nextTryAndExpectBtn = document.getElementById('next-try-and-expect');

        const sectionDetails = document.getElementById('section-details');
        const sectionTryAndExpect = document.getElementById('section-try-and-expect');

        // Enable 'Next' button if title is filled
        titleInput.addEventListener('input', function() {
            if (titleInput.value.trim() !== '') {
                nextDetailsBtn.disabled = false;
            } else {
                nextDetailsBtn.disabled = true;
            }
        });

        // Enable details section and inputs when 'Next' is clicked
        nextDetailsBtn.addEventListener('click', function() {
            sectionDetails.querySelectorAll('input, textarea, button').forEach(el => {
                el.disabled = false;
            });
            sectionDetails.classList.add('enabled');
            nextTryAndExpectBtn.disabled = false;
        });

        // Enable 'Next' button in details section if details are filled
        detailsInput.addEventListener('input', function() {
            if (detailsInput.value.trim() !== '') {
                nextTryAndExpectBtn.disabled = false;
            } else {
                nextTryAndExpectBtn.disabled = true;
            }
        });

        // Enable try and expect section and inputs when 'Next' is clicked
        nextTryAndExpectBtn.addEventListener('click', function() {
            sectionTryAndExpect.querySelectorAll('input, textarea, button').forEach(el => {
                el.disabled = false;
            });
            sectionTryAndExpect.classList.add('enabled');
            document.querySelector('button[type="submit"]').disabled = false;
        });
    });
</script>

<style>
    .form-section {
        margin-bottom: 20px;
    }

    .form-section.disabled input,
    .form-section.disabled textarea,
    .form-section.disabled button {
        background-color: #f5f5f5;
        color: #b3b3b3;
        border-color: #e0e0e0;
        cursor: not-allowed;
    }
</style>

@endsection
