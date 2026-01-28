@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
    <div class="container-fluid px-4 py-4" style="background-color: #ffffff; min-height: 100vh;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-gray-800 mb-0">User Profile</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="background: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-#a3a3a3">Home</a></li>
                    <li class="breadcrumb-item text-#a3a3a3 active">User Profile</li>
                </ol>
            </nav>
        </div>

        <!-- Profile Card -->
        <div class="card mb-4" style="background-color: #a3a3a3; border: none;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <h5 class="text-white mb-0">Profile</h5>
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal"
                        data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>

                <div class="d-flex align-items-center">
                    <!-- Profile Picture -->
                    <div class="position-relative me-4">
                        @if (Auth::user()->profile_picture)
                            <img src="{{ Auth::user()->profile_picture }}" alt="Profile" class="rounded-circle"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                                style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <span style="font-size: 48px; font-weight: 600;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Info -->
                    <div class="flex-grow-1">
                        <h3 class="text-white mb-1">{{ Auth::user()->name }}</h3>
                        <p class="text-white-50 mb-3">
                            {{ Auth::user()->job_title ?? 'Team Manager' }} |
                            {{ Auth::user()->location ?? 'Arizona, United States.' }}
                        </p>

                        <!-- Social Links -->
                        <div class="d-flex gap-2">
                            <a href="{{ Auth::user()->facebook_url ?? '#' }}" class="btn btn-sm"
                                style="background-color: #3a4a5f; color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="{{ Auth::user()->twitter_url ?? '#' }}" class="btn btn-sm"
                                style="background-color: #3a4a5f; color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="{{ Auth::user()->linkedin_url ?? '#' }}" class="btn btn-sm"
                                style="background-color: #3a4a5f; color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="{{ Auth::user()->instagram_url ?? '#' }}" class="btn btn-sm"
                                style="background-color: #3a4a5f; color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Card -->
        <div class="card mb-4" style="background-color: #a3a3a3; border: none;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <h5 class="text-white mb-0">Personal Information</h5>
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal"
                        data-bs-target="#editPersonalInfoModal">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">First Name</label>
                        <p class="text-white mb-0">{{ explode(' ', Auth::user()->name)[0] ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">Last Name</label>
                        <p class="text-white mb-0">{{ explode(' ', Auth::user()->name)[1] ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">Email address</label>
                        <p class="text-white mb-0">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">Phone</label>
                        <p class="text-white mb-0">{{ Auth::user()->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12">
                        <label class="text-white-50 small mb-1">Bio</label>
                        <p class="text-white mb-0">{{ Auth::user()->bio ?? 'Team Manager' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Card -->
        <div class="card" style="background-color: #a3a3a3; border: none;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <h5 class="text-white mb-0">Address</h5>
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal"
                        data-bs-target="#editAddressModal">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">Country</label>
                        <p class="text-white mb-0">{{ Auth::user()->country ?? 'United States' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">City/State</label>
                        <p class="text-white mb-0">{{ Auth::user()->city_state ?? 'Phoenix, United States' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">Postal Code</label>
                        <p class="text-white mb-0">{{ Auth::user()->postal_code ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-white-50 small mb-1">TAX ID</label>
                        <p class="text-white mb-0">{{ Auth::user()->tax_id ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #263447; border: none;">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Edit Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.update-basic') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-white">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}"
                                required style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Job Title</label>
                            <input type="text" class="form-control" name="job_title"
                                value="{{ Auth::user()->job_title }}"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Location</label>
                            <input type="text" class="form-control" name="location"
                                value="{{ Auth::user()->location }}"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Profile Picture</label>
                            <input type="file" class="form-control" name="profile_picture" accept="image/*"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Personal Info Modal -->
    <div class="modal fade" id="editPersonalInfoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #263447; border: none;">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Edit Personal Information</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.update-personal') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-white">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}"
                                required style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Bio</label>
                            <textarea class="form-control" name="bio" rows="3"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">{{ Auth::user()->bio }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Address Modal -->
    <div class="modal fade" id="editAddressModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #263447; border: none;">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Edit Address</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.update-address') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-white">Country</label>
                            <input type="text" class="form-control" name="country"
                                value="{{ Auth::user()->country }}"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">City/State</label>
                            <input type="text" class="form-control" name="city_state"
                                value="{{ Auth::user()->city_state }}"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Postal Code</label>
                            <input type="text" class="form-control" name="postal_code"
                                value="{{ Auth::user()->postal_code }}"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">TAX ID</label>
                            <input type="text" class="form-control" name="tax_id"
                                value="{{ Auth::user()->tax_id }}"
                                style="background-color: #1a2332; border-color: #3a4a5f; color: white;">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
