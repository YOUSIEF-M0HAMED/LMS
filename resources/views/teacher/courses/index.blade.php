@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher Home
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row courses-container">
            @if ($courses->count() > 0)
                @foreach ($courses as $course)
                    <div class="col-lg-6 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body row">
                                @if ($course->logo != null)
                                    <a href="{{ route('teacher.courses.show', $course->id) }}" class="col-sm-12 col-lg-4"><img
                                            src="{{ asset($course->logo) }}" class="w-100" alt="" /></a>
                                @else
                                    <a href="{{ route('teacher.courses.show', $course->id) }}"
                                        class="col-sm-12 col-lg-4"><img src="{{ asset('courses/course.jpeg') }}"
                                            class="w-100" alt="" /></a>
                                @endif
                                <div class="col-lg-8 col-sm-12">
                                    <a href="{{ route('teacher.courses.show', $course) }}" class="">
                                        <h2 class="font-weight-bold">{{ $course->name }}</h2>
                                    </a>
                                    <p class="description">
                                        {{ $course->specification }}
                                    </p>
                                    <div class="mt-2 d-flex justify-content-end">
                                        <a href="{{ route('teacher.courses.show', $course) }}"
                                            class="btn btn-primary me-2">Visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>Sorry There Are No Uploaded Courses For You Yet !!</h3>
            @endif
        </div>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/courses.js') }}"></script>
@endsection
