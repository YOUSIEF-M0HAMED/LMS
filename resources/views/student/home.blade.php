@extends('student.layouts.app')
@section('pageTitle')
    Student Home
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row courses-container">
            <div class="row">
                <div class="col-12">
                    <h1>{{ __('messages.welcome') }},
                        {{ Auth::guard('student')->user()->fname . ' ' . Auth::guard('student')->user()->lname }}</h1>
                </div>
            </div>
            @if ($courses->count() > 0)
                @foreach ($courses as $course)
                    <div class="col-lg-6 col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body row">
                                @if ($course->logo != null)
                                    <a href="{{ route('teacher.courses.show', $course->id) }}" class="col-sm-12 col-lg-4"><img
                                            src="{{ asset($course->logo) }}" class="w-100" alt="" /></a>
                                @else
                                    <a href="{{ route('teacher.courses.show', $course->id) }}"
                                        class="col-sm-12 col-lg-4"><img src="{{ asset('courses/course.jpeg') }}"
                                            class="w-100" alt="" /></a>
                                @endif
                                <div class="col-lg-8 col-sm-12">
                                    <a href="{{ route('student.courses.showCourse', $course) }}" class="">
                                        <h2 class="font-weight-bold">{{ $course->name }}</h2>
                                    </a>
                                    <p class="description">
                                        {{ $course->specification }}
                                    </p>
                                    <div class="mt-2 d-flex justify-content-end">
                                        <a href="{{ route('student.courses.showCourse', $course) }}"
                                            class="btn btn-primary me-2">Visit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3> No Referenced Courses For You Yet !!</h3>
            @endif
        {{-- </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card text-dark bg-light">
                    <div class="card-header text-white fw-bold bg-info">Quizzes Statistics</div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-6 mt-5" style="font-size: 18px;">
                                <ul class="align-self-center">
                                    <li class="mb-2">
                                        <strong>Total Quizzes:</strong>
                                        <span class="fw-bold">{{ $totalQuizzes }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Total Active Quizzes:</strong>
                                        <span class="fw-bold">{{ $activeQuizzes }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Total Upcoming Quizzes:</strong>
                                        <span class="fw-bold">{{ $upcomingQuizzes }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Total Completed Quizzes:</strong>
                                        <span class="fw-bold">{{ $completedQuizzes }}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <canvas id="quizChart" style="max-width: 100%; margin: 0 auto;"></canvas>
                            </div>
                        </div>
                    </div>
                </div> --}}
            {{-- </div> --}}

            <!-- // END OF MA EDITS -->
        </div>
    </div>
@endsection
{{-- @section('pageScript')
    <script src="{{ asset('assets/js/courses.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('quizChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Completed', 'Active', 'Upcoming'],
                    datasets: [{
                        label: 'Quizzes Status',
                        data: [
                            {{ $completedQuizzes }},
                            {{ $activeQuizzes }},
                            {{ $upcomingQuizzes }}
                        ],
                        backgroundColor: [
                            '#28a745', // Completed (Green)
                            '#007bff', // Active (Blue)
                            '#ffc107' // Upcoming (Yellow)
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + ((tooltipItem.raw /
                                        {{ $totalQuizzes }}) * 100).toFixed(2) + '%';
                                }
                            }
                        },
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        });
    </script> --}}
{{-- @endsection --}}
