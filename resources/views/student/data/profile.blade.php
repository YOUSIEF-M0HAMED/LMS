@extends('student.layouts.app')
@section('pageTitle')
    Student Profile
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
                            @if (Auth::guard('student')->user()->image != null)
                                <form id="photoForm-1"
                                    action="{{ route('student.change_profile_photo', Auth::guard('student')->user()->id) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <label for="profile-image-1" style="cursor: pointer;">
                                        <div class="profile-image mt-4 mb-2">
                                            <img class="img-fluid img-thumbnail mt-4 mb-2 w-100"
                                                src="{{ asset(Auth::guard('student')->user()->image) }}" alt="">
                                        </div>
                                    </label>
                                    <input type="file" name="image" id="profile-image-1" onchange="submitForm()"
                                        style="display: none;">
                                </form>
                            @else
                                <form id="photoForm-1"
                                    action="{{ route('student.change_profile_photo', Auth::guard('student')->user()->id) }}"
                                    method="post" enctype="multipart/form-data">
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
                            <a href="{{ route('student.confirm_password', Auth::guard('student')->user()->id) }}"
                                class="btn btn-outline-dark mt-3 mt-sm-2 photo-edit" data-mdb-ripple-color="dark">
                                Edit profile
                            </a>
                        </div>
                        <div class="ms-3 main-info-holder">
                            <h5>Welcome Back,</h5>
                            <p>{{ Auth::guard('student')->user()->fname }}</p>
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
                                            {{ Auth::guard('student')->user()->fname . ' ' . Auth::guard('student')->user()->lname }}
                                        </p>
                                    </div>
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Email:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">
                                            {{ Auth::guard('student')->user()->email }}</p>
                                    </div>
                                </div>

                                <div class="additional-info d-none">
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Student Id:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">
                                            {{ Auth::guard('student')->user()->student_id }}</p>
                                    </div>
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Username:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">
                                            {{ Auth::guard('student')->user()->username }}</p>
                                    </div>
                                    <div class="me-2 p-2 w-100 mb-2">
                                        <p class="first font-italic mb-1 d-inline-block">Phone:</p>
                                        <p class="font-italic mb-1 d-inline-block fw-bold">
                                            {{ Auth::guard('student')->user()->phone }}</p>
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
