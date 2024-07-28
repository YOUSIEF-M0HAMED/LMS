@extends('admin.layouts.app')
@section('pageTitle')
    Admin Courses & Students
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses_students.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Create') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.course_student.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="student_id" class="col-md-4 col-form-label text-md-end">Student Name</label>

                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <!-- Dropdown button -->
                                        <select id="student_id" name="student_id"
                                            class="form-select @error('student_id') is-invalid @enderror"
                                            aria-label="Default select example">
                                            @foreach ($allStudents as $student)
                                                <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                                    {{ $student->fname . ' ' . $student->lname }}</option>
                                            @endforeach
                                        </select>
                                        @error('student_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="course_id" class="col-md-4 col-form-label text-md-end">Student Name</label>

                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <!-- Dropdown button -->
                                        <select id="course_id" name="course_id"
                                            class="form-select @error('course_id') is-invalid @enderror"
                                            aria-label="Default select example">
                                            @foreach ($allCourses as $course)
                                                <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                                                    {{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('course_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>

                                    <a href="{{ route('admin.course_student.index') }}" class="btn btn-warning ms-3">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/courses_students.js') }}"></script>
@endsection
