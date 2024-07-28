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
            <li id="notifications"><i class="fa-regular fa-bell"></i>
                <ul class="shadow-sm">
                    <li>
                        <a href="#">comment</a>
                    </li>
                    <li>
                        <a href="#">comment</a>
                    </li>
                    <li>
                        <a href="#">comment</a>
                    </li>
                    <li>
                        <a href="#">comment</a>
                    </li>
                </ul>
            </li>
            <li id="user-info" class="li-user-setting">
                @if (Auth::guard('teacher')->user()->image != null)
                    <img class="profile-img" src="{{ asset(Auth::guard('teacher')->user()->image) }}" alt="">
                @else
                    <i class='fa-solid fa-user profile-icon'></i>
                @endif
                <ul class="shadow-sm">
                    <li>
                        <a href="{{ route('teacher.profile') }}" class="d-flex">
                            @if (Auth::guard('teacher')->user()->image != null)
                                <img class="profile-img" src="{{ asset(Auth::guard('teacher')->user()->image) }}"
                                    alt="">
                            @else
                                <i class='fa-solid fa-user profile-icon'></i>
                            @endif
                            <p class="user mb-0">{{ Auth::guard('teacher')->user()->fname }}
                                <span class="user-role d-block">Teacher</span>
                            </p>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('teacher.logout') }}">
                            <i class="fa-solid fa-right-from-bracket me-2 fs-6"></i>
                            Logout</a>
                    </li>
                </ul>
            </li>
        </div>
    </div>
</nav>
