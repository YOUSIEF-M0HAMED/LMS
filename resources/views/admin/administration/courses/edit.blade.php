@extends('admin.layouts.app')
@section('pageTitle')
    Create new course
@endsection
@section('pageStyle')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Create') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.course.update', $course) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="teacher_id" class="col-md-4 col-form-label text-md-end">Teacher
                                    (OPTIONAL)</label>

                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <!-- Dropdown button -->
                                        <select id="teacher_id" name="teacher_id"
                                            class="form-select @error('teacher_id') is-invalid @enderror"
                                            aria-label="Default select example">
                                            <option selected value="">Later</option>
                                            @foreach ($teachers as $teacher)
                                                <option @if ($course->teacher_id == $teacher->id) selected @endif
                                                    value="{{ $teacher->id }}">{{ $teacher->fname . ' ' . $teacher->lname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="course_code"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Course Code') }}</label>

                                <div class="col-md-6">
                                    <input id="course_code" type="text"
                                        class="form-control @error('course_code') is-invalid @enderror" name="course_code"
                                        value="{{ $course->course_code }}" autocomplete="course_code" autofocus>

                                    @error('course_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $course->name }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="specification"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Specification') }}</label>

                                <div class="col-md-6">
                                    <textarea id="specification" type="text" class="form-control h-100 @error('specification') is-invalid @enderror"
                                        name="specification" autocomplete="specification" autofocus>{{ $course->specification }}</textarea>

                                    @error('specification')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="logo"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Logo') }}</label>

                                <div class="col-md-6">
                                    <input id="logo" type="file"
                                        class="form-control @error('logo') is-invalid @enderror" name="logo"
                                        value="{{ old('logo') }}" autocomplete="logo" autofocus>

                                    @error('logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Edit') }}
                                    </button>

                                    <a href="{{ route('admin.course.index') }}" class="btn btn-warning ms-3">
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
@endsection
