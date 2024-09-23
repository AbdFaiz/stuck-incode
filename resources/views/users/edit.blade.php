@extends('layouts.app')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.profile.update', Auth::id()) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Display User Avatar -->
                        <div class="text-center mb-4">
                            @if (Auth::user()->image)
                            <!-- Jika ada foto profil -->
                            <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="User Avatar" style="height: 15rem; width: 15rem;" class="rounded-circle">
                            @else
                            <!-- Jika tidak ada foto profil, tampilkan inisial nama -->
                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-secondary text-white" style="height: 15rem; width: 15rem; font-size: 5rem;">
                                {{ strtoupper(Auth::user()->name[0]) }}
                            </div>
                            @endif

                            <h4 class="card-title">{{ Auth::user()->name }}</h4>
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ Auth::user()->name }}" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ Auth::user()->email }}" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="bio">Bio</label>
                            <textarea name="bio" class="form-control" id="bio">{{ Auth::user()->bio }}</textarea>
                        </div>

                        <div class="form-group mb-2">
                            <label for="image">Profile picture</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection