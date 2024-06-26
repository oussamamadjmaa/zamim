<header id="header">
    <div class="phone-nav">
        <div class="toggle-nav-menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path
                    d="M17.5401 9.06001C15.7701 9.06001 14.3301 7.62001 14.3301 5.85001C14.3301 4.08001 15.7701 2.64001 17.5401 2.64001C19.3101 2.64001 20.7501 4.08001 20.7501 5.85001C20.7501 7.62001 19.3101 9.06001 17.5401 9.06001ZM17.5401 4.13001C16.6001 4.13001 15.8301 4.90001 15.8301 5.84001C15.8301 6.78001 16.6001 7.55001 17.5401 7.55001C18.4801 7.55001 19.2501 6.78001 19.2501 5.84001C19.2501 4.90001 18.4801 4.13001 17.5401 4.13001Z"
                    class="fill-dark" />
                <path
                    d="M6.46001 9.06001C4.69001 9.06001 3.25 7.62001 3.25 5.85001C3.25 4.08001 4.69001 2.64001 6.46001 2.64001C8.23001 2.64001 9.67 4.08001 9.67 5.85001C9.67 7.62001 8.23001 9.06001 6.46001 9.06001ZM6.46001 4.13001C5.52001 4.13001 4.75 4.90001 4.75 5.84001C4.75 6.78001 5.52001 7.55001 6.46001 7.55001C7.40001 7.55001 8.17 6.78001 8.17 5.84001C8.17 4.90001 7.41001 4.13001 6.46001 4.13001Z"
                    class="fill-dark" />
                <path
                    d="M17.5401 21.37C15.7701 21.37 14.3301 19.93 14.3301 18.16C14.3301 16.39 15.7701 14.95 17.5401 14.95C19.3101 14.95 20.7501 16.39 20.7501 18.16C20.7501 19.93 19.3101 21.37 17.5401 21.37ZM17.5401 16.44C16.6001 16.44 15.8301 17.21 15.8301 18.15C15.8301 19.09 16.6001 19.86 17.5401 19.86C18.4801 19.86 19.2501 19.09 19.2501 18.15C19.2501 17.21 18.4801 16.44 17.5401 16.44Z"
                    class="fill-dark" />
                <path
                    d="M6.46001 21.37C4.69001 21.37 3.25 19.93 3.25 18.16C3.25 16.39 4.69001 14.95 6.46001 14.95C8.23001 14.95 9.67 16.39 9.67 18.16C9.67 19.93 8.23001 21.37 6.46001 21.37ZM6.46001 16.44C5.52001 16.44 4.75 17.21 4.75 18.15C4.75 19.09 5.52001 19.86 6.46001 19.86C7.40001 19.86 8.17 19.09 8.17 18.15C8.17 17.21 7.41001 16.44 6.46001 16.44Z"
                    class="fill-dark" />
            </svg>
        </div>
        <div class="toggle-user-menu">
            <a href="#" class="link-dark"><ion-icon name="person-outline"></ion-icon></a>
        </div>
    </div>
    <nav id="navbar">
        <div class="container">
            <a href="{{ route('web.home') }}"><x-logos.frontend-logo /></a>

            <ul>
                <li>
                    <a href="{{ route('web.home') }}" class="active">ماهي الإذاعة المدرسية؟</a>
                </li>
                <li>
                    <a href="{{ route('web.home') }}#faq">الأسئلة الشائعة</a>
                </li>
                <li>
                    <a href="{{ route('web.home') }}#">تواصل معنا</a>
                </li>
            </ul>

            <ul class="mt-auto mt-lg-0">
                <li>
                    <a href="#" class="active">المساعدة</a>
                </li>
                <li class="d-mobile-none">
                    <a href="#"><ion-icon name="globe-outline"></ion-icon></a>
                </li>
                <li class="d-mobile-none">
                    <a href="{{ route('school.login') }}"><ion-icon name="person"></ion-icon></a>
                </li>
                <li>
                    <div class="mode-toggle-button">
                        <input type="checkbox" id="darkModeToggle" class="sr-only" :checked="preferredMode == 'dark-mode'">
                        <label for="darkModeToggle" class="mode-toggle-label" title="Switch mode">
                            <x-icons.sun />
                            <x-icons.moon />
                        </label>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="nav-overlay"></div>
</header>
