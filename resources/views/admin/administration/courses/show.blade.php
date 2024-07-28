@extends('admin.layouts.app')
@section('pageTitle')
    Create new course
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection
@section('content')
    <h2 class="mb-3">Course Name</h2>
    <div class="container">

        <div class="dropdown row content-headers mb-2">
            <button class="btn btn-secondary dropdown-toggle d-flex justify-content-between align-items-center" type="button"
                id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menu
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item p-2 fw-bold text-white" href="#">Content</a>
                <a class="dropdown-item p-2 fw-bold text-white" href="#">Assignment</a>
                <a class="dropdown-item p-2 fw-bold text-white" href="#">Quizes</a>
            </div>
        </div>
        <div class="content-details">
            <div class="contents row d-flex">
                <div class="col-lg-4 index">
                    @if (count($courseContentFiles) > 0)
                        <div class="row content-contents">

                            <ol class="list-group list-group-numbered p-3">
                                @foreach ($courseContentFiles as $courseFile)
                                    @if ($courseFile->file_type == 'video')
                                        <li class="list-group-item row d-flex">
                                            <a href="{{ asset($courseFile->file_path) }}"
                                                class="videoLink col-10">{{ $courseFile->file_name }}</a>
                                        </li>
                                    @elseif($courseFile->file_type == 'image')
                                        <li class="list-group-item row d-flex">

                                            <a href="{{ asset($courseFile->file_path) }}"
                                                class="imageLink col-10">{{ $courseFile->file_name }}</a>
                                        </li>
                                    @else
                                        <li class="list-group-item row d-flex">

                                            <a href="{{ asset($courseFile->file_path) }}"
                                                class="fileLink col-10">{{ $courseFile->file_name }}</a>
                                        </li>
                                    @endif
                                @endforeach

                            </ol>

                        </div>
                    @else
                        <h3> No Course Content Files Uploaded Yet</h3>
                    @endif
                </div>
                <div class="col-lg-8 index-details"></div>
            </div>
            <div class="assignments row d-none">
                <div class="col-lg-4 index">
                    @if (count($courseAssignmentFiles) > 0)
                        <div class="row content-contents">

                            <ol class="list-group list-group-numbered p-3">
                                @foreach ($courseAssignmentFiles as $courseFile)
                                    @if ($courseFile->file_type == 'video')
                                        <li class="list-group-item row d-flex">

                                            <a href="{{ asset($courseFile->file_path) }}"
                                                class="videoLink col-10">{{ $courseFile->file_name }}</a>
                                        </li>
                                    @elseif($courseFile->file_type == 'image')
                                        <li class="list-group-item row d-flex">

                                            <a href="{{ asset($courseFile->file_path) }}"
                                                class="imageLink col-10">{{ $courseFile->file_name }}</a>
                                        </li>
                                    @else
                                        <li class="list-group-item row d-flex">

                                            <a href="{{ asset($courseFile->file_path) }}"
                                                class="fileLink col-10">{{ $courseFile->file_name }}</a>
                                        </li>
                                    @endif
                                @endforeach

                            </ol>

                        </div>
                    @else
                        <h3> No Course Assignments Files Uploaded Yet</h3>
                    @endif
                </div>
                <div class="col-lg-8 index-details">

                </div>
            </div>
        </div>

    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/courses.js') }}"></script>
@endsection
