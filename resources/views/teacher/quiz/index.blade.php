@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher quizzes
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/quizzes.css') }}">
@endsection
@section('content')
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-10 p-0 mt-2">
                <div class="text-center">
                    <a class="btn btn-success" href="{{ route('teacher.quiz.create') }}">Create Quiz</a>
                </div>
            </div>
        </div>
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
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz_num++ }}</td>
                            <th><a href="{{ route('teacher.quiz.show', $quiz->id) }}">{{ $quiz->title }}</a></th>
                            <td>{{ $quiz->from_time }}</td>
                            <td>{{ $quiz->to_time }}</td>
                            <td>{{ $quiz->duration }}</td>
                            <td>
                                <a href="{{ route('teacher.quiz.show', $quiz->id) }}"><i class="fa-solid fa-eye"
                                        style="color: #3dd5f3"></i></a>
                                <a href="{{ route('teacher.quiz.edit', $quiz->id) }}"><i class="fa-solid fa-wrench px-3"
                                        style="color: #0d6efd"></i></a>
                                <form action="{{ route('teacher.quiz.destroy', $quiz->id) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none;background: transparent;"><i
                                            class="fa-solid fa-trash" style="color: #dc3545;"></i></button>
                                </form>
                            </td>
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
@section('pageScript')
    <script src="{{ asset('assets/js/quizzes.js') }}"></script>
@endsection
