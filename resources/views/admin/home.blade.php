@extends('admin.layouts.app')
@section('pageTitle')
    Admin Home
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/home.css') }}">
    <style>
        .card-title {
            font-size: 2rem;
        }

        .card-title,
        .card-label {
            font-weight: 700;
        }

        .card-label {
            padding-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .progress-bar-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection
@section('content')
    <div class="admin-home container-fluid overflow-hidden p-0">

        <div class="row">
            <div class="col-12">
                <h1>{{ __('messages.welcome') }},
                    {{ Auth::guard('admin')->user()->fname . ' ' . Auth::guard('admin')->user()->lname }}</h1>
            </div>
        </div>
        <div class="row justify-content-center my-4">
            <div class="col-12">
                <div class="row gy-4">
                    <div class="col-12 col-sm-6">
                        <div class="card widget-card border-light shadow-sm">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title widget-card-title mb-3">Teachers</h5>
                                        <h4 class="card-subtitle text-body-secondary m-0">{{ $teacherCount }}</h4>
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
                    <div class="col-12 col-sm-6">
                        <div class="card widget-card border-light shadow-sm">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title widget-card-title mb-3">Courses</h5>
                                        <h4 class="card-subtitle text-body-secondary m-0">{{ $coursesNumbers }}</h4>
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

        {{-- progress bar stats --}}
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card text-dark bg-light mb-3">
                    <div class="card-header text-white fw-bold bg-info">Students</div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="card-label ">Total Students</h5>
                                <p class="card-title">{{$studentCount}}</p>
                            </div>
                            <div class="col-md-4">
                                <div id="onlineStudentsCircle" style="width: 150px; height: 150px; margin: auto;"></div>
                                <h5 class="card-title mt-2">{{ number_format($onlineStudentPercentage, 2) }}%</h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="card-label">Online Students</h5>
                                <p class="card-title">{{ $onlineStudentCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card text-dark bg-light mb-3">
                    <div class="card-header text-white fw-bold bg-info">Teachers</div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-4">
                                <h5 class="card-label">Total Teachers</h5>
                                <p class="card-title"> {{ $teacherCount }}</p>
                            </div>
                            <div class="col-md-4">
                                <div id="onlineTeachersCircle" style="width: 150px; height: 150px; margin: auto;"></div>
                                <h5 class="card-title mt-2"> {{ number_format($onlineTeacherPercentage, 2) }}%</h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="card-label">Online Teachers</h5>
                                <p class="card-title"> {{ $onlineTeacherCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- quizzes stats --}}
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card text-dark bg-light">
                    <div class="card-header text-white fw-bold bg-info">Quizzes Statistics</div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <ul>
                                    <li>
                                        <strong>Total Quizzes:</strong>
                                        <span class="fw-bold"> {{ $totalQuizzes }}</span>
                                    </li>
                                    <li>
                                        <strong>Total Active Quizzes:</strong>
                                        <span class="fw-bold">{{ $activeQuizzes }}</span>
                                    </li>
                                    <li>
                                        <strong>Total Upcoming Quizzes:</strong>
                                        <span class="fw-bold"> {{ $upcomingQuizzes }} </span>
                                    </li>
                                    <li>
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
        </div>

    </div>
@endsection
@section('pageScript')
    <script src="{{ asset('assets/js/admin/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/progressbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Define progress bar data
            var progressBars = [{
                    id: 'onlineStudentsCircle',
                    percentage:{{ $onlineStudentPercentage / 100 }} ,
                    gradientId: 'studentGradient',
                    colorFrom: '#0d6efd',
                    colorTo: '#28a745'
                },
                {
                    id: 'onlineTeachersCircle',
                    percentage: {{ $onlineTeacherPercentage / 100 }},
                    gradientId: 'teacherGradient',
                    colorFrom: '#0d6efd',
                    colorTo: '#6f42c1'
                }

                // Add more objects for additional progress bars if needed
            ];

            // Loop through progressBars array to initialize each progress bar
            progressBars.forEach(function(barData) {
                var bar = new ProgressBar.Circle('#' + barData.id, {
                    color: '#28a745',
                    trailColor: '#e4e4e4',
                    strokeWidth: 8,
                    trailWidth: 8,
                    easing: 'easeInOut',
                    duration: 1400,
                    text: {
                        autoStyleContainer: false
                    },
                    from: {
                        color: barData.colorFrom,
                        width: 8
                    },
                    to: {
                        color: barData.colorTo,
                        width: 8
                    },
                    // Set default step function for all animate calls
                    step: function(state, circle) {
                        var gradient = 'url(#' + barData.gradientId + ')';
                        circle.path.setAttribute('stroke', gradient);
                        circle.path.setAttribute('stroke-width', state.width);

                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            circle.setText('');
                        } else {
                            circle.setText(value + '%');
                        }
                    }
                });

                bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
                bar.text.style.fontSize = '2rem';

                bar.animate(barData.percentage); // Number from 0.0 to 1.0

                // Add SVG gradient definitions
                addGradientDefinition(barData.gradientId, barData.colorFrom, barData.colorTo);
            });

            // Function to add SVG gradient definition
            function addGradientDefinition(id, startColor, endColor) {
                var svg = document.querySelector('svg');
                var defs = document.createElementNS('http://www.w3.org/2000/svg', 'defs');
                var linearGradient = document.createElementNS('http://www.w3.org/2000/svg', 'linearGradient');
                linearGradient.setAttribute('id', id);
                linearGradient.setAttribute('x1', '0%');
                linearGradient.setAttribute('y1', '0%');
                linearGradient.setAttribute('x2', '0%');
                linearGradient.setAttribute('y2', '100%');

                var stop1 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
                stop1.setAttribute('offset', '0%');
                stop1.setAttribute('style', 'stop-color:' + startColor + ';stop-opacity:1');
                linearGradient.appendChild(stop1);

                var stop2 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
                stop2.setAttribute('offset', '100%');
                stop2.setAttribute('style', 'stop-color:' + endColor + ';stop-opacity:1');
                linearGradient.appendChild(stop2);

                defs.appendChild(linearGradient);
                svg.appendChild(defs);
            }

            // quizzed chart
            var ctx = document.getElementById('quizChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Upcoming', 'Active'],
                    datasets: [{
                        label: 'Quiz Status',
                        data: [{{ $completedQuizzes }},
                            {{ $upcomingQuizzes }},
                            {{ $activeQuizzes }}, ],
                        backgroundColor: [
                            '#28a745', // Completed (Green)
                            '#ffc107', // Upcoming (Yellow)
                            '#007bff' // Active (Blue)
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.label + ': ' + ((tooltipItem.raw /
                                    {{ $totalQuizzes }}) * 100).toFixed(2) + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
