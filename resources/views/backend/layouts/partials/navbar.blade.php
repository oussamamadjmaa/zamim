<div class="navbar" id="navbar">
    <div class="d-flex align-items-center">
        <a class="sidebar-icon me-3" href="javascript:;" onclick="(document.body.classList.toggle('toggle-sidebar'))">
            <x-icons.backend.sidebar />
        </a>
        <a class="star-icon me-4 d-none d-lg-block" href="javascript:;">
            <x-icons.backend.star />
        </a>
        <div class="d-none d-lg-block">
            <nav class="breadcrumb mb-0">
                <a class="breadcrumb-item" href="/">@lang('Dashboard')</a>
                @if(isset($title) && !in_array($title, [__('Dashboard'), __('Home')]))
                    <span class="breadcrumb-item active" aria-current="page">{{ $title }}</span>
                @endif
            </nav>
        </div>
    </div>
    <div class="d-flex align-items-center">
        <!-- Search, Notifications, Messages, Language -->
        <div class="d-flex align-items-center">
            <div class="search-bar"></div>

            <!-- Notifications -->
            <navbar-notifications-component></navbar-notifications-component>
            <!-- Notifications -->


            <!-- Messages -->
            {{-- <div class="dropdown">
                <a class="nav-link" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="iconsax" icon-name="messages-1"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end phone-fixed-dropdown" aria-labelledby="messagesDropdown">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/avatars/2.png" alt="User Avatar" width="50"
                                        class="rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">جون دو</h6>
                                    <p class="p4 mb-0">مرحبا, كيف يمكنني مساعدتك؟</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/avatars/3.jpg" alt="User Avatar" width="50"
                                        class="rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">جون سميث</h6>
                                    <p class="p4 mb-0">الرجاء مراجعة طلب التسجيل الخاص بي.</p>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>

            </div> --}}

            <!-- Language -->
            <div class="dropdown">
                <a class="nav-link" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="iconsax" icon-name="globe"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="messagesDropdown">
                    <li>
                        <a class="dropdown-item" href="{{route($routePrefix.'.lang', 'ar')}}">العربية</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route($routePrefix.'.lang', 'en')}}">English</a>
                    </li>
                </ul>

            </div>
        </div>

        <!-- User Dropdown menu -->
        <div class="ms-4">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ auth()->user()->avatar }}" alt="User Profile Picture" width="30"
                        class="rounded-circle me-2"> <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route($routePrefix.'.profile.index') }}">@lang('Profile')</a>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="javascript:;" onclick="document.getElementById('logoutForm').submit()">@lang('Logout')</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
