@extends('admin.layouts.app')
@section('pageTitle')
    All Students
@endsection
@section('pageStyle')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/student/home.css') }}"> --}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class ="col-md-6">
            <div class="form-group">
                <form method = "get" action= "{{ route('admin.students.search') }}">
                    @csrf
                    <div class = "input-group">
                        <input class="form-control" name="search" placeholder= "search for student ...">
                        <button type ="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <form action="{{ route('admin.students.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id=""
                    class="form-control @error('file') is-invalid @enderror">
                @error('file')
                    <span class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="btn btn-success mt-2">Import Students</button>
            </form>
            <div class="col-md-10 p-0 mt-2">
                <div class="text-center">
                    <a href="{{ route('admin.students.export') }}" class="btn btn-primary">Export Students</a>
                    <a class="btn btn-success" href="{{ route('admin.students.create') }}">Create Student</a>
                    <a class="btn btn-secondary" href="{{ route('admin.students.deleted') }}">Deleted Students</a>
                    <form action="{{ route('admin.students.destroy_all') }}" method="post" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete All</button>
                    </form>
                </div>
            </div>
        </div>
        @if (is_array($allStudents) || $allStudents instanceof Countable)
            <table class="table text-center mt-4">
                <thead>
                    <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Last Seen</th>
                        <th scope= "col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($student1))
                        @foreach ($student1 as $studentData)
                            <tr>
                                <td>{{ $studentData->student_id }}</td>
                                <td>{{ $studentData->username }}</td>
                                <td>{{ $studentData->fname }}</td>
                                <td>{{ $studentData->lname }}</td>
                                <td>{{ Carbon\Carbon::parse($studentData->last_seen)->diffForHumans() }}</td>
                                <td>
                                    @if ($studentData->last_seen >= now()->subMinutes(2))
                                        <button type="submit" class="btn btn-success">Online</button>
                                    @else
                                        <span>

                                            <button type="submit" class="btn btn-danger">Offline</button>
                                        </span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('admin.students.show', $studentData->id) }}"
                                        class="btn btn-info">View</a>
                                    <a href="{{ route('admin.students.edit', $studentData->id) }}"
                                        class="btn btn-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.students.destroy', $studentData->id) }}"
                                        style="display: inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($allStudents as $studentData)
                            <tr>
                                <td>{{ $studentData->student_id }}</td>
                                <td>{{ $studentData->username }}</td>
                                <td>{{ $studentData->fname }}</td>
                                <td>{{ $studentData->lname }}</td>
                                <td>{{ Carbon\Carbon::parse($studentData->last_seen)->diffForHumans() }}</td>
                                <td>
                                    @if ($studentData->last_seen >= now()->subMinutes(2))
                                        <button type="submit" class="btn btn-success">Online</button>
                                    @else
                                        <span>

                                            <button type="submit" class="btn btn-danger">Offline</button>
                                        </span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{ route('admin.students.show', $studentData->id) }}"
                                        class="btn btn-info">View</a>
                                    <a href="{{ route('admin.students.edit', $studentData->id) }}"
                                        class="btn btn-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.students.destroy', $studentData->id) }}"
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
    {{-- <script src="{{ asset('assets/js/student/home.js') }}"></script> --}}
@endsection
