@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher quizzes
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/quizzes.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Create Quiz') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('teacher.quiz.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label for="title"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Quiz Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}" autocomplete="title" autofocus>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="course_id" class="col-md-4 col-form-label text-md-end">Course</label>

                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <!-- Dropdown button -->
                                        <select id="course_id" name="course_id"
                                            class="form-select @error('course_id') is-invalid @enderror"
                                            aria-label="Default select example">
                                            @php
                                                $teacher = Auth::guard('teacher')->user();
                                                $courses = $teacher->courses;
                                            @endphp
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}" @selected($course->id == old('course_id'))>
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
                                <label for="from_time"
                                    class="col-md-4 col-form-label text-md-end">{{ __('From Time') }}</label>

                                <div class="col-md-6">
                                    <input id="from_time" type="datetime-local"
                                        class="form-control @error('from_time') is-invalid @enderror" name="from_time"
                                        value="{{ old('from_time') }}" autocomplete="from_time" autofocus>

                                    @error('from_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="to_time"
                                    class="col-md-4 col-form-label text-md-end">{{ __('To Time') }}</label>



                                <div class="col-md-6">
                                    <input id="to_time" type="datetime-local"
                                        class="form-control @error('to_time') is-invalid @enderror" name="to_time"
                                        value="{{ old('to_time') }}" autocomplete="to_time" autofocus>

                                    @error('to_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="duration"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Duration') }}</label>

                                <div class="col-md-6">
                                    <input id="duration" type="number"
                                        class="form-control @error('duration') is-invalid @enderror" name="duration"
                                        value="{{ old('duration') }}" autocomplete="duration"
                                        placeholder="duration in minutes" autofocus>

                                    @error('duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Create') }}
                                    </button>

                                    <a href="{{ route('teacher.quiz.index') }}" class="btn btn-warning ms-3">
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
    <script src="{{ asset('assets/js/quizzes.js') }}"></script>
@endsection
