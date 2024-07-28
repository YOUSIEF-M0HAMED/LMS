{{-- resources/views/student/quiz/result.blade.php --}}
@extends('student.layouts.app')

@section('pageTitle', 'Quiz Result')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mt-5">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body text-center">
                        <h3>Your Score: {{ $score }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
