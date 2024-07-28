@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher Questions
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/questions.css') }}">
@endsection
@section('content')
    <div class="container">

        <div class="">
            <div class="card">
                <div class="card-header">{{ __('Create Question') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('teacher.question.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="quiz_id" value="{{ $quiz_id }}">
                        <div class="mb-3">
                            <label for="question" class="form-label fw-bold">Question</label>
                            <textarea name="question" class="form-control @error('question') is-invalid @enderror" id="question" rows="4"
                                autocomplete="question" autofocus>{{ old('question') }}</textarea>
                            @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_a" class="form-label">Option A</label>
                            <input type="text" name="option_a"
                                class="form-control @error('option_a') is-invalid @enderror" id="option_a"
                                value="{{ old('option_a') }}" autocomplete="option_a" autofocus>
                            @error('option_a')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_b" class="form-label">Option B</label>
                            <input type="text" name="option_b"
                                class="form-control @error('option_b') is-invalid @enderror" id="option_b"
                                value="{{ old('option_b') }}" autocomplete="option_b" autofocus>
                            @error('option_b')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_c" class="form-label">Option C</label>
                            <input type="text" name="option_c"
                                class="form-control @error('option_c') is-invalid @enderror" id="option_c"
                                value="{{ old('option_c') }}" autocomplete="option_c" autofocus>
                            @error('option_c')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="option_d" class="form-label">Option D</label>
                            <input type="text" name="option_d"
                                class="form-control @error('option_d') is-invalid @enderror" id="option_d"
                                value="{{ old('option_d') }}" autocomplete="option_d" autofocus>
                            @error('option_d')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Correct Option</label>
                            @error('correct_option')
                                <span role="alert"
                                    class="text-danger small d-block mb-3"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="correct_option" value="option_a"
                                    id="option_radio_a" @checked(old('correct_option') == 'option_a')>
                                <label class="form-check-label" for="option_radio_a">
                                    Option A
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="correct_option" value="option_b"
                                    id="option_radio_b" @checked(old('correct_option') == 'option_b')>
                                <label class="form-check-label" for="option_radio_b">
                                    Option B
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="correct_option" value="option_c"
                                    id="option_radio_c" @checked(old('correct_option') == 'option_c')>
                                <label class="form-check-label" for="option_radio_c">
                                    Option C
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="correct_option" value="option_d"
                                    id="option_radio_d" @checked(old('correct_option') == 'option_d')>
                                <label class="form-check-label" for="option_radio_d">
                                    Option D
                                </label>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>

                                <a href="{{ route('teacher.question.index', $quiz_id) }}" class="btn btn-warning ms-3">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/questions.js') }}"></script>
@endsection
