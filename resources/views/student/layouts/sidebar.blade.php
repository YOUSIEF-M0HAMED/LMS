<aside id="sidebar" class="layout-menu">
    <div class="sidebar-logo">
        <a href="{{ route('student.home') }}">
            <img class="logo" src="{{ asset('assets/imgs/Logo.svg') }}" alt="" />
        </a>
        <span type="button" id="btn-close-sidebar" class="btn-close btn-close-sidebar"></span>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{ route('student.home') }}" id="1" class="sidebar-link sub-item mx-1"><i
                    class="fa-solid fa-chart-line pe-2"></i>Dashboard</a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('student.home') }}" id="3" class="sidebar-link sub-item mx-1"><i
                    class="fa-regular fa-bookmark pe-2"></i>View
                courses</a>
        </li>
        <li class="sidebar-item">
            <a href="#" id="main-item-1" class="sidebar-link collapsed main-item mx-1" data-bs-toggle="collapse"
                data-bs-target="#Quizes" aria-expanded="false" aria-controls="Quizes">
                <i class="fa-regular fa-file-lines pe-2"></i>
                Quizes
            </a>
            <ul id="Quizes" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">

                <li class="sidebar-item">
                    <a href="{{ route('student.quizGrade.showQuizzes') }}" id="4"
                        class="sidebar-link sub-item mx-1">
                        <i class="fa-solid fa-circle ps-2 me-2"></i>
                        Take quiz</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('student.quizGrade.showGrades') }}" id="5"
                        class="sidebar-link sub-item mx-1">
                        <i class="fa-solid fa-circle ps-2 me-2"></i>
                        View grades</a>
                </li>
            </ul>
        </li>
        <li class="sidebar-header p-3 ps-3">Social</li>
        <li class="sidebar-item">
            <a href="{{ route('student.post.index') }}" class="sidebar-link sub-item mx-1"><i
                    class="fa-solid fa-paste pe-2"></i>Posts</a>
        </li>

    </ul>
</aside>
