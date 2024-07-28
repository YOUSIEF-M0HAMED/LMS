<aside id="sidebar" class="layout-menu">
    <div class="sidebar-logo">
        <a href="{{ route('admin.home') }}">
            <img class="logo" src="{{ asset('assets/imgs/Logo.svg') }}" alt="">
        </a>
        <span type="button" id="btn-close-sidebar" class="btn-close btn-close-sidebar"></span>
    </div>
    <!-- Sidebar Navigation -->
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="{{ route('admin.home') }}" id="1" class="sidebar-link sub-item mx-1"><i
                    class="fa-solid fa-chart-line pe-2"></i>Dashboard</a>
        </li>
        <li class="sidebar-item">
            <a href="#" id="main-item-2" class="sidebar-link collapsed  main-item  mx-1" data-bs-toggle="collapse"
                data-bs-target="#layout" aria-expanded="false" aria-controls="layout">
                <i class="fa-regular fa-file-lines pe-2"></i>
                Site Adminstration
            </a>
            <ul id="layout" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="{{ route('admin.admins.index') }}" id="4" class="sidebar-link sub-item mx-1">
                        <i class="fa-solid fa-circle ps-2 me-2"></i>
                        Admins</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.teachers.index') }}" id="5" class="sidebar-link sub-item mx-1">
                        <i class="fa-solid fa-circle ps-2 me-2"></i>
                        Teachers</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.students.index') }}" id="6" class="sidebar-link sub-item mx-1">
                        <i class="fa-solid fa-circle ps-2 me-2"></i>
                        Students</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.course.index') }}" id="7" class="sidebar-link sub-item mx-1">
                        <i class="fa-solid fa-circle ps-2 me-2"></i>
                        Courses</a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ route('admin.course_student.index') }}" id="8"
                        class="sidebar-link sub-item mx-1">
                        <i class="fa-solid fa-circle ps-2 me-2"></i>
                        Courses & Students</a>
                </li>
            </ul>
        </li>

        <li class="sidebar-header p-3 ps-3">Social</li>
        <li class="sidebar-item">
            <a href="{{ route('admin.post.index') }}" class="sidebar-link sub-item mx-1"><i
                    class="fa-solid fa-paste pe-2"></i>Posts</a>
        </li>
    </ul>
</aside>
