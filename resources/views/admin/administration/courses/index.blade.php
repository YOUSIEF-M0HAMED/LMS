@extends('admin.layouts.app')
@section('pageTitle')
    Create new course
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('admin.course.import') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" id="" class="form-control @error('file') is-invalid @enderror">
            @error('file')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <button type="submit" class="btn btn-success mt-2">Import Courses</button>
        </form>
        <div class="col-md-10 p-0 mt-2">
            <div>
                <a href="{{ route('admin.course.export') }}" class="btn btn-primary mb-3 mt-2">Export Courses</a>
                <a href="{{ route('admin.course.create') }}" class="btn btn-success mb-3 mt-2">
                    Create Course
                </a>
            </div>
        </div>

        <div class="row courses-container">
            @if (count($courses) > 0)
                @foreach ($courses as $course)
                    <div class="col-lg-6 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body row">
                                @if ($course->logo != null)
                                    <a href="{{ route('admin.course.show', $course->id) }}" class="col-sm-12 col-lg-4"><img
                                            src="{{ asset($course->logo) }}" class="w-100" alt="" /></a>
                                @else
                                    <a href="{{ route('admin.course.show', $course->id) }}" class="col-sm-12 col-lg-4"><img
                                            src="{{ asset('courses/course.jpeg') }}" class="w-100" alt="" /></a>
                                @endif
                                <div class="col-lg-8 col-sm-12">
                                    <a href="{{ route('admin.course.show', $course->id) }}" class="">
                                        <h2 class="font-weight-bold">{{ $course->name }}</h2>
                                    </a>
                                    <p class="fw-bold">
                                        <span>Teacher Name</span> : @if ($course->teacher)
                                            {{ $course->teacher->fname . ' ' . $course->teacher->lname }}
                                        @else
                                            no teacher
                                        @endif
                                    </p>
                                    <p class="description">
                                        {{ $course->specification }}
                                    </p>
                                    <div class="mt-2 d-flex justify-content-center">
                                        <a href="{{ route('admin.course.show', $course) }}"
                                            class="btn btn-primary me-2">Visit</a>
                                        <a href="{{ route('admin.course.edit', $course) }}"
                                            class="btn btn-secondary me-2">Edit</a>
                                        <form action="{{ route('admin.course.destroy', $course) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger me-2">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-10 p-0 mt-5">
                    <div class="text-center">
                        No courses
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('pageScript')
@endsection
