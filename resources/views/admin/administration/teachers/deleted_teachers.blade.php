@extends('admin.layouts.app')
@section('pageTitle')
    All Deleted Teachers
@endsection
@section('pageStyle')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/student/home.css') }}"> --}}
@endsection
@section('content')
    <div class="container-fluid">

        <div class="col-md-10 p-0 mt-2">
            <div class="text-center">
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Back to Teachers</a>
                <form action="{{ route('admin.teachers.restore_all') }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Restore All</button>
                </form>
                <form action="{{ route('admin.teachers.force_delete_all') }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete All Permanently</button>
                </form>
            </div>
        </div>

        <table class="table text-center mt-4">
            <thead>
                <tr>
                    <th scope="col">Teacher ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deletedTeachers as $deletedTeacher)
                    <tr>
                        <td>{{ $deletedTeacher->teacher_id }}</td>
                        <td>{{ $deletedTeacher->username }}</td>
                        <td>{{ $deletedTeacher->fname }}</td>
                        <td>{{ $deletedTeacher->lname }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.teachers.restore', $deletedTeacher->id) }}"
                                style="display: inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">Restore</button>
                            </form>
                            <form method="POST" action="{{ route('admin.teachers.force_delete', $deletedTeacher->id) }}"
                                style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Permanently</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('pageScript')
    {{-- <script src="{{ asset('assets/js/student/home.js') }}"></script> --}}
@endsection
