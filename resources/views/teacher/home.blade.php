@extends('teacher.layouts.app')
@section('pageTitle')
    Teacher Home
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/teacher/home.css') }}">
@endsection
@section('content')
    <div class="teacher-home container-fluid overflow-hidden p-0">

        <div class="row">
            <div class="col-12">
                <h1>Welcome,
                    {{ Auth::guard('teacher')->user()->fname . ' ' . Auth::guard('teacher')->user()->lname }}
                </h1>
            </div>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-12">
                <div class="row gy-4">
                    @foreach ($teacherCourses as $course )



                    <div class="col-12 col-sm-6">
                        <div class="card widget-card border-light shadow-sm">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title widget-card-title mb-3">Your Students for {{$course->name}} Course</h5>
                                        <h4 class="card-subtitle text-body-secondary m-0">{{$course->students_count}}</h4>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="lh-1 text-white bg-info rounded-circle p-3 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-person fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-12 col-sm-6">
                        <div class="card widget-card border-light shadow-sm">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title widget-card-title mb-3">Your Courses</h5>
                                        <h4 class="card-subtitle text-body-secondary m-0">{{$numberOfCourses}}</h4>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="lh-1 text-white bg-info rounded-circle p-3 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-book fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                                        <span class="fw-bold"> {{ $totalQuizzes }}</span>
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
                </div>
            </div>

            <!-- // END OF MA EDITS -->
        </div>
    @endsection
    @section('pageScript')
        <script src="{{ asset('assets/js/teacher/home.js') }}"></script>
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
                            data: [{{ $completedQuizzes }},
                            {{ $activeQuizzes }},
                            {{ $upcomingQuizzes }},

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
                                        return tooltipItem.label + ': ' + ((tooltipItem.raw /{{ $totalQuizzes }} ) * 100)
                                            .toFixed(2) + '%';
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
        </script>
    @endsection
