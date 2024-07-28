@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher Questions
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/questions.css') }}">
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
                    <a class="btn btn-success" href="{{ route('teacher.question.create', $quiz_id) }}">Create Question</a>
                </div>
            </div>
        </div>
        @php
            $question_num = 1;
        @endphp
        @if (count($questions) > 0)
            @foreach ($questions as $question)
                <div class="card mt-3">
                    <div class="card-header text-center">
                        Question no. {{ $question_num }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $question->question }}</h5>
                        <p class="card-text">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Options</label>
                            @error('correct_option')
                                <span role="alert"
                                    class="text-danger small d-block mb-3"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="{{ 'correct_option' . $question_num }}"
                                    value="" id="{{ 'option_radio_a' . $question_num }}" disabled
                                    @checked($question->correct_option == 'option_a')>
                                <label class="form-check-label" for="{{ 'option_radio_a' . $question_num }}">
                                    {{ $question->option_a }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="{{ 'correct_option' . $question_num }}" value=""
                                    id="{{ 'option_radio_b' . $question_num }}" disabled @checked($question->correct_option == 'option_b')>
                                <label class="form-check-label" for="{{ 'option_radio_b' . $question_num }}">
                                    {{ $question->option_b }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="{{ 'correct_option' . $question_num }}" value=""
                                    id="{{ 'option_radio_c' . $question_num }}" disabled @checked($question->correct_option == 'option_c')>
                                <label class="form-check-label" for="{{ 'option_radio_c' . $question_num }}">
                                    {{ $question->option_c }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="{{ 'correct_option' . $question_num }}" value=""
                                    id="{{ 'option_radio_d' . $question_num }}" disabled @checked($question->correct_option == 'option_d')>
                                <label class="form-check-label" for="{{ 'option_radio_d' . $question_num }}">
                                    {{ $question->option_d }}
                                </label>
                            </div>

                        </div>
                        </p>
                        <a href="{{ route('teacher.question.edit', $question->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('teacher.question.destroy', $question->id) }}" method="POST"
                            style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        {{ $question->quiz->title }} Quiz -->> {{ $question->quiz->course->name }} Course
                    </div>
                </div>
                @php
                    $question_num++;
                @endphp
            @endforeach
        @else
            <div class="row mt-5">
                <div class="col-md-6 mx-auto">
                    <div class="alert alert-primary alert-dismissible fade show text-center" role="alert">
                        No questions
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/questions.js') }}"></script>
@endsection
