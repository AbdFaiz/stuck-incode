@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <!-- Display User Avatar -->
                        <img src="{{ Auth::user()->avatar_url }}" alt="User Avatar" class="img-thumbnail rounded-circle mb-3"
                            style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <!-- Display User Name -->
                        <h4 class="card-title">{{ Auth::user()->name }}</h4>
                        <p class="text-muted mb-1">Reputation: {{ Auth::user()->reputation ?? 'N/A' }}</p>
                        <p class="text-muted mb-1">Joined: {{ Auth::user()->created_at->format('M d, Y') }}</p>
                        
                        <!-- Edit Profile Button -->
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm mt-2">Edit Profile</a>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5>Profile Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Bio:</strong> {{ Auth::user()->bio ?? 'This user has not written a bio.' }}</p>
                        <p><strong>Location:</strong> {{ Auth::user()->location ?? 'Not specified' }}</p>
                        <p><strong>Website:</strong> <a href="{{ Auth::user()->website ?? '#' }}" target="_blank">{{ Auth::user()->website ?? 'Not provided' }}</a></p>
                    </div>
                </div>

                <!-- Additional Stats or User Activity -->
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h5>Activity</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Questions Asked:</strong> {{ $questions_count ?? 0 }}</p>
                        <p><strong>Answers Given:</strong> {{ $answers_count ?? 0 }}</p>
                        <p><strong>Saved Posts:</strong> {{ $saved_posts_count ?? 0 }}</p>
                    </div>
                </div>

                <!-- Include Livewire Component -->
                @livewire('user-profile')
            </div>
        </div>
    </div>
@endsection
