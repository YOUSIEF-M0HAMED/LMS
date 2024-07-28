@extends('admin.layouts.app')
@section('pageTitle')
    All Teachers
@endsection
@section('pageStyle')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/teacher/home.css') }}"> --}}
@endsection
@section('content')

    <div class="container-fluid">
        <div class ="col-md-6">
            <div class="form-group">
                <form method = "get" action= "{{ route('admin.teachers.search_teachers') }}">
                    @csrf
                    <div class = "input-group">
                        <input class="form-control" name="search" placeholder= "search for teacher ...">
                        <button type ="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <form action="{{ route('admin.teachers.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id=""
                    class="form-control @error('file') is-invalid @enderror">
                @error('file')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="btn btn-success mt-2">Import Teachers</button>
            </form>
            <div class="col-md-10 p-0 mt-2">
                <div class="text-center">
                    <a href="{{ route('admin.teachers.export') }}" class="btn btn-primary">Export Teachers</a>
                    <a class="btn btn-success" href="{{ route('admin.teachers.create') }}">Create Teacher</a>
                    <a class="btn btn-secondary" href="{{ route('admin.teachers.deleted') }}">Deleted Teachers</a>

                </div>
            </div>
        </div>
        @if (count($allTeachers) > 0)
            <table class="table text-center mt-4">
                <thead>
                    <tr>
                        <th scope="col">Teacher ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Last Seen</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($teacher1))
                        @foreach ($teacher1 as $teacherData)
                            <td>{{ $teacherData->teacher_id }}</td>
                            <td>{{ $teacherData->username }}</td>
                            <td>{{ $teacherData->fname }}</td>
                            <td>{{ $teacherData->lname }}</td>
                            <td>{{ Carbon\Carbon::parse($teacherData->last_seen)->diffForHumans() }}</td>
                            <td>
                                @if ($teacherData->last_seen >= now()->subMinutes(2))
                                    <button type="submit" class="btn btn-success">Online</button>
                                @else
                                    <span>

                                        <button type="submit" class="btn btn-danger">Offline</button>
                                    </span>
                                @endif

                            </td>
                            <td>
                                <a href="{{ route('admin.teachers.show', $teacherData->id) }}"
                                    class="btn btn-info">View</a>
                                <a href="{{ route('admin.teachers.edit', $teacherData->id) }}"
                                    class="btn btn-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.teachers.destroy', $teacherData->id) }}"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($allTeachers as $teacherData)
                            <tr>
                                <td>{{ $teacherData->teacher_id }}</td>
                                <td>{{ $teacherData->username }}</td>
                                <td>{{ $teacherData->fname }}</td>
                                <td>{{ $teacherData->lname }}</td>
                                <td>{{ Carbon\Carbon::parse($teacherData->last_seen)->diffForHumans() }}</td>
                                <td>
                                    @if ($teacherData->last_seen >= now()->subMinutes(2))
                                        <button type="submit" class="btn btn-success">Online</button>
                                    @else
                                        <span>

                                            <button type="submit" class="btn btn-danger">Offline</button>
                                        </span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('admin.teachers.show', $teacherData->id) }}"
                                        class="btn btn-info">View</a>
                                    <a href="{{ route('admin.teachers.edit', $teacherData->id) }}"
                                        class="btn btn-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.teachers.destroy', $teacherData->id) }}"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @else
            <div class="col-md-10 p-0 mt-5">
                <div class="text-center">
                    No courses
                </div>
            </div>
        @endif
    </div>
@endsection
@section('pageScript')
    {{-- <script src="{{ asset('assets/js/teacher/home.js') }}"></script> --}}
@endsection
