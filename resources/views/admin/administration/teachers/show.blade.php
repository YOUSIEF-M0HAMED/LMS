@extends('admin.layouts.app')
@section('pageTitle')
    Teacher Profile
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endsection
@section('content')
    <div class="container-fluid">

        <div class="profile-container row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7 p-0">
                <div class="card">
                    <div class="first-div rounded-top text-white d-flex flex-row">
                        <div class="ms-4 mt-5 d-flex flex-column">
                            @if ($teacher->image != null)
                                <form id="photoForm-1"
                                    action="{{ route('admin.teachers.change_profile_photo', $teacher->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label for="profile-image-1" style="cursor: pointer;">
                                        <div class="profile-image mt-4 mb-2">
                                            <img class="img-fluid img-thumbnail mt-4 mb-2 w-100"
                                                src="{{ asset($teacher->image) }}" alt="">
                                        </div>
                                    </label>
                                    <input type="file" name="image" id="profile-image-1" onchange="submitForm()"
                                        style="display: none;">
                                </form>
                            @else
                                <form id="photoForm-1"
                                    action="{{ route('admin.teachers.change_profile_photo', $teacher->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label for="profile-image-2" style="cursor: pointer;">
                                        <div class="profile-image mt-4 mb-2">
                                            <img class="img-fluid img-thumbnail mt-4 mb-2 w-100"
                                                src="{{ asset('assets/imgs/temp_profile.jpg') }}" alt="">
                                        </div>
                                    </label>
                                    <input type="file" name="image" id="profile-image-2" onchange="submitForm()"
                                        style="display: none;">
                                </form>
                            @endif
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}"
                                class="btn btn-outline-dark mt-3 mt-sm-2 photo-edit" data-mdb-ripple-color="dark">
                                Edit profile
                            </a>
                        </div>
                        <div class="ms-3 main-info-holder">
                            {{-- <p>{{ $teacher->fname }}</p> --}}
                        </div>
                    </div>
                    <div class="card-body p-4 text-black">
                        <div class="mb-5">
                            <p class="lead fw-normal mb-1">About</p>
                            <div class="info-holder p-4">
                                <div class="important-info">
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Full Name:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">
                                            {{ $teacher->fname . ' ' . $teacher->lname }}</p>
                                    </div>
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Email:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">{{ $teacher->email }}</p>
                                    </div>
                                </div>

                                <div class="additional-info d-none">
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Teacher Id:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">{{ $teacher->teacher_id }}</p>
                                    </div>
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Username:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">{{ $teacher->username }}</p>
                                    </div>
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Phone:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">{{ $teacher->phone }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <button type="button" class="btn btn-outline-dark info-shower" data-mdb-ripple-color="dark">
                                Show more
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/profile.js') }}"></script>
@endsection
