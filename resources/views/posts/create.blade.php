@extends('layouts.app')

@section('title', 'stackInCode')

@section('content')
<div class="section-header mb-4">
    <h1 class="fw-bold fs-3">Ask a Public Question</h1>
</div>

<div class="row">
    <!-- Left Instructions Column -->
    <div class="col-md-8">
        <!-- Instructions Section -->
        <section class="instruction-section mb-4 p-4 border bg-light">
            <h2 class="fw-bold fs-4">Writing a Good Question</h2>
            <p>You're ready to ask a programming-related question and this form will help guide you through the process.</p>
            <p>Looking to ask a non-programming question? See the topics <a href="#">here</a> to find a relevant site.</p>
            
            <h3>Steps</h3>
            <ol>
                <li>Summarize your problem in a one-line title.</li>
                <li>Describe your problem in more detail.</li>
                <li>Describe what you tried and what you expected to happen.</li>
                <li>Add “tags” which help surface your question to members of the community.</li>
                <li>Review your question and post it to the site.</li>
            </ol>
        </section>

        <!-- Form Section -->
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <div class="form-section mb-4">
                <label for="title" class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Is there an R function for finding the index of an element in a vector?" required>
                <button type="button" class="btn btn-primary mt-2" id="next-details" disabled>Next</button>
            </div>

            <div class="form-section mb-4 disabled" id="section-details">
                <label for="details" class="form-label fw-bold">What are the details of your problem?</label>
                <textarea class="form-control" id="details" name="details" rows="5" placeholder="Introduce the problem and expand on what you put in the title." disabled></textarea>
                <button type="button" class="btn btn-primary mt-2" id="next-try-and-expect" disabled>Next</button>
            </div>

            <div class="form-section mb-4 disabled" id="section-try-and-expect">
                <label for="try_and_expect" class="form-label fw-bold">What did you try and what were you expecting?</label>
                <textarea class="form-control" id="try_and_expect" name="try_and_expect" rows="5" placeholder="Describe what you tried, what you expected to get, and what actually happened." disabled></textarea>
                <button type="submit" class="btn btn-primary mt-2" disabled>Submit</button>
            </div>
        </form>
    </div>

    <!-- Right Panel (Tips on writing a good title) -->
    <div class="col-md-4">
        <div class="bg-light p-3 border">
            <h4 class="fw-bold">Writing a good title</h4>
            <p>Your title should summarize the problem.</p>
            <p>You might find that you have a better idea of your title after writing out the rest of the question.</p>
        </div>
    </div>
</div>

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
            nextDetailsBtn.disabled = titleInput.value.trim() === '';
        });

        // Enable details section and inputs when 'Next' is clicked
        nextDetailsBtn.addEventListener('click', function() {
            sectionDetails.classList.remove('disabled');
            detailsInput.disabled = false;
            sectionDetails.style.display = 'block';
        });

        // Enable 'Next' button in details section if details are filled
        detailsInput.addEventListener('input', function() {
            nextTryAndExpectBtn.disabled = detailsInput.value.trim() === '';
        });

        // Enable try and expect section and inputs when 'Next' is clicked
        nextTryAndExpectBtn.addEventListener('click', function() {
            sectionTryAndExpect.classList.remove('disabled');
            tryAndExpectInput.disabled = false;
            sectionTryAndExpect.style.display = 'block';
            document.querySelector('button[type="submit"]').disabled = false;
        });
    });
</script>

@endsection
