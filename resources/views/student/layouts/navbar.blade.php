<nav class="layout-navbar row m-0 shadow-sm">
    <div class="layout-navbar-content d-flex justify-content-between align-items-center m-0 p-0">
        <form class="d-flex align-items-center">
            <button class="btn-open-sidebar" id="btn-open-sidebar" type="button" data-bs-theme="light">
                <i class="fa-solid fa-bars"></i>
            </button>
            <span class="search-button">
                <i class="fa-solid fa-magnifying-glass ms-3"></i>
                <input class="search-input d-none d-sm-inline-block  me-2 border-white pointer-event" type="search"
                    placeholder="Search..." aria-label="Search" />
                <span class="close-icon-input">&times;</span>
            </span>
        </form>
        <div class="user-settings d-flex">
            <li id="languages" class="li-user-setting">
                <i class="fa-solid fa-language"></i>
                <ul class="shadow-sm">
                    <li><a href="{{ route('switch.language', 'en') }}" class="active">English</a></li>
                    <li><a href="{{ route('switch.language', 'ar') }}">Arabic</a></li>
                </ul>
            </li>
            <li id="color-modes" class="li-user-setting">
                <i class="fa-regular fa-sun"></i>
                <ul class="shadow-sm">
                    <li>
                        <a href="#" class="active">
                            <i class="fa-regular fa-sun ms-2 me-2 fs-6"></i>
                            Light
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-regular fa-moon ms-2 me-2 fs-6"></i>
                            Dark
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa-solid fa-desktop ms-2 me-2 fs-6"></i>
                            System
                        </a>
                    </li>
                </ul>
            </li>

            <li id="notifications" class="dropdown">
                <i class="fa-regular fa-bell"></i>
                <span class="badge">no notifications :
                    {{ auth()->guard('student')->user()->unreadNotifications->count() }}</span>
                <ul class="dropdown-menu shadow-sm">
                    @if ($notifications->isEmpty())
                        <li class="dropdown-item">No new notifications</li>
                    @else
                        @foreach ($notifications as $notification)
                            @if ($notification->type == 'App\Notifications\NewMessageNotification')
                                <li class="dropdown-item">
                                    <a
                                        href="{{ route('student.chat.show', [
                                            'courseId' => $notification->data['course_id'],
                                            'userId' => Auth::guard('student')->id(),
                                        ]) }}">
                                        new message (' {{ $notification->data['message'] }} ') on course
                                        {{ $notification->data['course_name'] }}
                                    </a>
                                    <br>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                    <a href="{{ route('student.notifications.read', $notification->id) }}"
                                        class="btn btn-sm btn-primary">Mark as read</a>
                                </li>
                            @elseif ($notification->type == 'App\Notifications\FileUploadedNotification')
                                <li class="dropdown-item">
                                    <a
                                        href="{{ route('student.courses.showCourse', $notification->data['course_id']) }}">
                                        new file (' {{ $notification->data['file_name'] }} ') uploaded to course :
                                        {{ $notification->data['course_name'] }}
                                    </a>
                                    <br>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                    <a href="{{ route('student.notifications.read', $notification->id) }}"
                                        class="btn btn-sm btn-primary">Mark as read</a>
                                </li>
                            @elseif ($notification->type == 'App\Notifications\QuizAddedNotification')
                                <li class="dropdown-item">
                                    <a href="{{ route('student.quizGrade.showQuizzes') }}">
                                        new Quiz (' {{ $notification->data['quiz_title'] }} ') on course
                                        {{ $notification->data['course_name'] }}
                                    </a>
                                    <br>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                    <a href="{{ route('student.notifications.read', $notification->id) }}"
                                        class="btn btn-sm btn-primary">Mark as read</a>
                                </li>
                            @endif
                        @endforeach
                        <form action="{{ route('student.notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-3">Mark all as read</button>
                        </form>
                    @endif
                </ul>
            </li>


            <li id="user-info" class="li-user-setting">
                @if (Auth::guard('student')->user()->image != null)
                    <img class="profile-img" src="{{ asset(Auth::guard('student')->user()->image) }}" alt="">
                @else
                    <i class='fa-solid fa-user profile-icon'></i>
                @endif
                <ul class="shadow-sm">
                    <li>
                        <a href="{{ route('student.profile') }}" class="d-flex">
                            @if (Auth::guard('student')->user()->image != null)
                                <img class="profile-img" src="{{ asset(Auth::guard('student')->user()->image) }}"
                                    alt="">
                            @else
                                <i class='fa-solid fa-user profile-icon'></i>
                            @endif
                            <p class="user mb-0">{{ Auth::guard('student')->user()->fname }}
                                <span class="user-role d-block">Student</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.logout') }}">
                            <i class="fa-solid fa-right-from-bracket me-2 fs-6"></i>
                            Logout</a>
                    </li>
                </ul>
            </li>
        </div>
    </div>
</nav>
