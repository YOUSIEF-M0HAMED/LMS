@extends('student.layouts.app')
@section('pageTitle')
    Student Home
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <h2 class="mb-3">{{ $course->name }} :</h2>
    <div class="container">
        <div class="row">
            <a href="{{ route('student.chat.show', ['courseId' => $course->id, 'userId' => Auth::guard('student')->id()]) }}"
                class="btn rounded bg-black text-white col-md-2 col-4 m-2">Chat</a>
        </div>
        <div class="dropdown row content-headers mb-2">
            <button class="btn btn-secondary dropdown-toggle d-flex justify-content-between align-items-center"
                type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Menu
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item p-2 fw-bold text-white" href="#">Lectures</a>
                <a class="dropdown-item p-2 fw-bold text-white" href="#">Assignments</a>
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
                                        <a href="{{ asset($courseFile->file_path) }}"
                                            class="videoLink col-10">{{ $courseFile->file_name }}</a>
                                    @elseif($courseFile->file_type == 'image')
                                        <a href="{{ asset($courseFile->file_path) }}"
                                            class="imageLink col-10">{{ $courseFile->file_name }}</a>
                                    @else
                                        <a href="{{ asset($courseFile->file_path) }}"
                                            class="fileLink col-10">{{ $courseFile->file_name }}</a>
                                    @endif
                                @endforeach

                            </ol>

                            <form method="POST"
                                action="{{ route('teacher.courses.courseFiles.destroyAllCourseContent', ['course' => $course]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn rounded bg-danger text-white mb-2 col-5">Delete
                                    All</button>
                            </form>
                        </div>
                    @else
                        <h3> No Course Content Files Uploaded Yet</h3>
                    @endif
                </div>
                <div class="col-lg-8 index-details">

                </div>
            </div>

            <div class="assignments row d-none">
                <div class="col-lg-4 index">
                    @if (count($courseAssignmentFiles) > 0)
                        <div class="row content-contents">
                            <ol class="list-group list-group-numbered p-3">
                                @foreach ($courseAssignmentFiles as $courseFile)
                                    @if ($courseFile->file_type == 'video')
                                        <a href="{{ asset($courseFile->file_path) }}"
                                            class="videoLink col-10">{{ $courseFile->file_name }}</a>
                                    @elseif($courseFile->file_type == 'image')
                                        <a href="{{ asset($courseFile->file_path) }}"
                                            class="imageLink col-10">{{ $courseFile->file_name }}</a>
                                    @else
                                        <a href="{{ asset($courseFile->file_path) }}"
                                            class="fileLink col-10">{{ $courseFile->file_name }}</a>
                                    @endif
                                @endforeach

                            </ol>

                            <form method="POST"
                                action="{{ route('teacher.courses.courseFiles.destroyAllCourseAssignments', ['course' => $course]) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn rounded bg-danger text-white mb-2 col-5">Delete
                                    All</button>
                            </form>
                        </div>
                    @else
                        <h3> No Course Assignments Files Uploaded Yet</h3>
                    @endif
                </div>
                <div class="col-lg-8 index-details">

                </div>
            </div>

            <div class="quizes row d-none">
                @php
                    $quiz_num = 1;
                @endphp
                @if (count($courseQuizzes) > 0)
                    <table class="table text-center mt-4">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">From Time</th>
                                <th scope="col">To Time</th>
                                <th scope="col">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courseQuizzes as $courseQuiz)
                                <tr>
                                    <td>{{ $quiz_num++ }}</td>
                                    <th><a
                                            href="{{ route('student.test.show', $courseQuiz->id) }}">{{ $courseQuiz->title }}</a>
                                    </th>
                                    <td>{{ $courseQuiz->from_time }}</td>
                                    <td>{{ $courseQuiz->to_time }}</td>
                                    <td>{{ $courseQuiz->duration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="row mt-5">
                        <div class="col-md-6 mx-auto">
                            <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
                                No quizzes
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/courses.js') }}"></script>
@endsection
