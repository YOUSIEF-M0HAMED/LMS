@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher Home
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Upload File</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

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
                        <form action="{{ route('teacher.courses.courseFiles.store', $course) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="file-type" class="col-md-4 col-form-label text-md-end">File type</label>
                                <div class="col-md-6">
                                    <div class="dropdown">
                                        <!-- Dropdown button -->
                                        <select name="file_type" class="form-select" aria-label="Default select example">
                                            <option selected>Select a file type</option>
                                            <option value="video">Video</option>
                                            <option value="image">Image</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="file-type" class="col-md-4 col-form-label text-md-end">Section</label>
                                <div class="col-md-6">
                                    <div>
                                        <select name="section" class="form-select" aria-label="Default select example">
                                            <option selected>Select a section</option>
                                            <option value="content">Content</option>
                                            <option value="assignment">Assignment</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="logo" class="col-md-4 col-form-label text-md-end">Uploaded File</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="uploadedFile" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-success" type="submit">
                                        Uplaod
                                    </button>
                                    <a href="#" class="btn btn-warning ms-3">Cancel</a>
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
    <script src="{{ asset('assets/js/courses.js') }}"></script>
@endsection
