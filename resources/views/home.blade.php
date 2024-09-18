@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Main row with sidebar and content -->
    <div class="row mt-4">
        <!-- Sidebar -->
        <div class="col-md-3 d-none d-md-block scrollable-sidebar">
            <div class="card mb-4">
                <div class="card-header">Public</div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action active">Home</a>
                    <a href="#" class="list-group-item list-group-item-action">Questions</a>
                    <a href="#" class="list-group-item list-group-item-action">Tags</a>
                    <a href="#" class="list-group-item list-group-item-action">Users</a>
                    <a href="#" class="list-group-item list-group-item-action">Badges</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Collectives</div>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item list-group-item-action">Your Organizations</a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Followed Tags</div>
                <div class="card-body">
                    <p>No tags followed yet.</p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">Your Stats</div>
                <div class="card-body">
                    <p><strong>Questions asked:</strong> 2</p>
                    <p><strong>Answers given:</strong> 5</p>
                    <p><strong>Reputation:</strong> 15</p>
                </div>
            </div>
        </div>

        <!-- Main content: Questions feed -->
        <div class="col-md-9 scrollable-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Top Questions</h2>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Ask Question</a>
            </div>

            <!-- Questions list -->
            <div class="list-group">
                <!-- Example question -->
                <div class="list-group-item list-group-item-action mb-2 p-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between">
                        <div class="question-meta">
                            <span class="badge bg-secondary me-2">2 votes</span>
                            <span class="badge bg-info me-2">1 answer</span>
                            <span class="badge bg-success">5 views</span>
                        </div>
                        <div class="question-time">
                            <small>asked 1 hour ago by User123</small>
                        </div>
                    </div>
                    <a href="#" class="h5 text-decoration-none d-block mt-2">How to fix Laravel routing issue?</a>
                    <small class="text-muted">Tags: <span class="badge bg-light text-dark">Laravel</span> <span class="badge bg-light text-dark">PHP</span></small>
                </div>

                <!-- Example question -->
                <div class="list-group-item list-group-item-action mb-2 p-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between">
                        <div class="question-meta">
                            <span class="badge bg-secondary me-2">10 votes</span>
                            <span class="badge bg-info me-2">5 answers</span>
                            <span class="badge bg-success">100 views</span>
                        </div>
                        <div class="question-time">
                            <small>asked 2 days ago by User456</small>
                        </div>
                    </div>
                    <a href="#" class="h5 text-decoration-none d-block mt-2">What's the difference between let and var in JavaScript?</a>
                    <small class="text-muted">Tags: <span class="badge bg-light text-dark">JavaScript</span> <span class="badge bg-light text-dark">ES6</span></small>
                </div>

                <!-- Example question -->
                <div class="list-group-item list-group-item-action mb-2 p-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between">
                        <div class="question-meta">
                            <span class="badge bg-secondary me-2">0 votes</span>
                            <span class="badge bg-info me-2">2 answers</span>
                            <span class="badge bg-success">20 views</span>
                        </div>
                        <div class="question-time">
                            <small>asked 3 days ago by User789</small>
                        </div>
                    </div>
                    <a href="#" class="h5 text-decoration-none d-block mt-2">Best practices for optimizing MySQL queries?</a>
                    <small class="text-muted">Tags: <span class="badge bg-light text-dark">MySQL</span> <span class="badge bg-light text-dark">Database</span></small>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
