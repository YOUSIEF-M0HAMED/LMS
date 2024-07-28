@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher || Students Grade
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection
@section('content')
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
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <a href="{{ route('teacher.grade.export', $quizId) }}" class="btn btn-primary col-md-2 col-4 m-2">Export
                    Excel
                    File</a>
            </div>
        </div>

        @php
            $student_num = 1;
        @endphp
        @if (count($students) > 0)
            <table class="table text-center mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student_num++ }}</td>
                            <td>{{ $student->student_id }}</td>
                            <td>{{ $student->fname . ' ' . $student->lname }}</td>
                            <td>
                                @if ($student->studentQuizzes->isNotEmpty())
                                    {{ $student->studentQuizzes->first()->score }}
                                @else
                                    {{ 0 }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="row mt-5">
                <div class="col-md-6 mx-auto">
                    <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
                        No grades
                    </div>
                </div>
            </div>
        @endif

    </div>

@endsection
