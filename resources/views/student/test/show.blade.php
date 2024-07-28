@extends('student.layouts.app')
@section('pageTitle')
    Student Quiz
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
        @php
            $question_num = 1;
        @endphp
        <form action="{{ route('student.test.store', $quiz_id) }}" method="post">
            @csrf
            @if (count($questions) > 0)
                @foreach ($questions as $question)
                    <div class="card mt-3">
                        <div class="card-header">
                            Question {{ $question_num }}
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
                                    <input class="form-check-input" type="radio"
                                        name="{{ 'correct_option' . $question->id }}" value="option_a"
                                        id="{{ 'option_radio_a' . $question->id }}">
                                    <label class="form-check-label" for="{{ 'option_radio_a' . $question->id }}">
                                        {{ $question->option_a }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="{{ 'correct_option' . $question->id }}" value="option_b"
                                        id="{{ 'option_radio_b' . $question->id }}">
                                    <label class="form-check-label" for="{{ 'option_radio_b' . $question->id }}">
                                        {{ $question->option_b }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="{{ 'correct_option' . $question->id }}" value="option_c"
                                        id="{{ 'option_radio_c' . $question->id }}">
                                    <label class="form-check-label" for="{{ 'option_radio_c' . $question->id }}">
                                        {{ $question->option_c }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="{{ 'correct_option' . $question->id }}" value="option_d"
                                        id="{{ 'option_radio_d' . $question->id }}">
                                    <label class="form-check-label" for="{{ 'option_radio_d' . $question->id }}">
                                        {{ $question->option_d }}
                                    </label>
                                </div>

                            </div>
                            </p>

                        </div>
                        <div class="card-footer text-body-secondary text-center">
                            {{ $question->quiz->title }} Quiz -->> {{ $question->quiz->course->name }} Course
                        </div>
                    </div>
                    @php
                        $question_num++;
                    @endphp
                @endforeach
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
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
