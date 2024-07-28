@extends('student.layouts.app')
@section('pageTitle')
    Student Quizzes
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
        @if (count($quizzes) > 0)
            <table class="table text-center mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">From Time</th>
                        <th scope="col">To Time</th>
                        <th scope="col">Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz_num++ }}</td>
                            <th><a href="{{ route('student.test.show', $quiz->id) }}">{{ $quiz->title }}</a>
                            </th>
                            <td>{{ $quiz->from_time }}</td>
                            <td>{{ $quiz->to_time }}</td>
                            <td>{{ $quiz->duration }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="row mt-5">
                <div class="col-md-6 mx-auto">
                    <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
                        No quizzes
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
