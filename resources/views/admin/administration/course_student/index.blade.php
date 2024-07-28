@extends('admin.layouts.app')
@section('pageTitle')
    Admin Courses & Students
@endsection
@section('pageStyle')
    <link rel="stylesheet" href="{{ asset('assets/css/courses_students.css') }}">
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
                    <a class="btn btn-success" href="{{ route('admin.course_student.create') }}">Assign Student to
                        Courses</a>
                </div>
            </div>
        </div>


        @php
            $stuent_num = 1;
        @endphp
        @if (count($students) > 0)
            <table class="table text-center mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Courses</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $stuent_num++ }}</td>
                            <th><a
                                    href="{{ route('admin.students.show', $student->id) }}">{{ $student->fname . ' ' . $student->lname }}</a>
                            </th>
                            <td>
                                <ul>
                                    @php
                                        $courses = $student->courses;
                                    @endphp
                                    @if (count($courses) > 0)
                                        @foreach ($courses as $course)
                                            <li>{{ $course->name }}</li>
                                        @endforeach
                                    @else
                                        No courses
                                    @endif
                                </ul>
                            </td>
                            <td>
                                @if (count($courses) > 0)
                                    @foreach ($courses as $course)
                                        <li><a href="{{ route('admin.course_student.edit', ['student' => $student->id, 'course' => $course->id]) }}"><i
                                                    class="fa-solid fa-wrench px-3" style="color: #0d6efd"></i></a>
                                            <form
                                                action="{{ route('admin.course_student.destroy', ['student' => $student->id, 'course' => $course->id]) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border: none;background: transparent;"><i
                                                        class="fa-solid fa-trash" style="color: #dc3545;"></i></button>
                                            </form>
                                        </li>
                                    @endforeach
                                @else
                                    ---
                                @endif
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
    <script src="{{ asset('assets/js/courses_students.js') }}"></script>
@endsection
