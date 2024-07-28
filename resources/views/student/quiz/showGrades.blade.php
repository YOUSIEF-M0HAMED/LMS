@extends('student.layouts.app')
@section('pageTitle')
    Student Grades
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

        @php
            $quiz_num = 1;
        @endphp
        @if (count($grades) > 0)
            <table class="table text-center mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Taken At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grades as $grade)
                        <tr>
                            <td>{{ $quiz_num++ }}</td>
                            <th>{{ $grade->quiz->title }}</th>
                            <td>{{ $grade->score }}</td>
                            <td>{{ $grade->taken_at }}</td>
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
