<aside id="sidebar" class="layout-menu">
    <div class="sidebar-logo">
        <a href="{{ route('teacher.home') }}">
            <img class="logo" src="{{ asset('assets/imgs/Logo.svg') }}" alt="" />
        </a>
        <span type="button" id="btn-close-sidebar" class="btn-close btn-close-sidebar"></span>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{ route('teacher.home') }}" id="1" class="sidebar-link sub-item mx-1"><i
                    class="fa-solid fa-chart-line pe-2"></i>Dashboard</a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('teacher.courses.index') }}" id="3" class="sidebar-link sub-item mx-1"><i
                    class="fa-regular fa-bookmark pe-2"></i>Courses
                management</a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('teacher.quiz.index') }}" id="4" class="sidebar-link sub-item mx-1"><i
                    class="fa-regular fa-file-lines pe-2"></i>Quizes
                management</a>
        </li>
        <li class="sidebar-header p-3 ps-3">Social</li>
        <li class="sidebar-item">
            <a href="{{ route('teacher.post.index') }}" class="sidebar-link sub-item mx-1"><i
                    class="fa-solid fa-paste pe-2"></i>Posts</a>
        </li>
    </ul>
</aside>
