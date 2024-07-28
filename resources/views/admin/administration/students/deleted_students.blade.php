@extends('admin.layouts.app')
@section('pageTitle')
    All Deleted Students
@endsection
@section('pageStyle')
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/student/home.css') }}"> --}}
@endsection
@section('content')
    <div class="container-fluid">

        <div class="col-md-10 p-0 mt-2">
            <div class="text-center">
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Back to Students</a>
                <form action="{{ route('admin.students.restore_all') }}" method="post" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Restore All</button>
                </form>
                <form action="{{ route('admin.students.force_delete_all') }}" method="post" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete All Permanently</button>
                </form>
            </div>
        </div>

        <table class="table text-center mt-4">
            <thead>
                <tr>
                    <th scope="col">Student ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deletedStudents as $deletedStudent)
                    <tr>
                        <td>{{ $deletedStudent->student_id }}</td>
                        <td>{{ $deletedStudent->username }}</td>
                        <td>{{ $deletedStudent->fname }}</td>
                        <td>{{ $deletedStudent->lname }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.students.restore', $deletedStudent->id) }}"
                                style="display: inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">Restore</button>
                            </form>
                            <form method="POST" action="{{ route('admin.students.force_delete', $deletedStudent->id) }}"
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
