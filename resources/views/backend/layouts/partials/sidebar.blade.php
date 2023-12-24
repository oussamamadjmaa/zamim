<div class="main-sidebar">
    <div class="logo-container">
        <x-logos.frontend-logo class="logo-dark" />
    </div>

    <div class="sidebar-content">
        <ul class="sidebar-links">
            @foreach ($sidebarLinks as $sidebarLink)
                @if (!$sidebarLink['has-access'])
                    @continue
                @endif
            <li class="sidebar-link active">
                <a href="{{ $sidebarLink['link'] }}">
                    <i class="iconsax" icon-name="{{ $sidebarLink['icon'] }}"></i> <span class="sidebar-link__text">{{ $sidebarLink['title'] }}</span>
                </a>
            </li>
            @endforeach

            {{-- <li class="sidebar-link">
                <a href="/statistics">
                    <i class="iconsax" icon-name="bar-graph-3"></i> <span class="sidebar-link__text">الاحصائيات</span>
                </a>
            </li>
            <li class="sidebar-link">
                <a href="#">
                    <i class="iconsax" icon-name="cash"></i> <span class="sidebar-link__text">الاشتراكات</span>
                </a>
            </li>
            <li class="sidebar-link">
                <a href="#">
                    <i class="iconsax" icon-name="nut"></i> <span class="sidebar-link__text">الاعدادات</span>
                </a>
            </li>
            <li class="sidebar-link">
                <a href="#">
                    <i class="iconsax" icon-name="user-2"></i> <span class="sidebar-link__text">الملف الشخصي</span>
                </a>
            </li> --}}
        </ul>

        {{-- <div class="website-visits-graph-box">
            <h6 class="h10">زيارات الموقع</h6>
            <p>40%+
                <x-icons.backend.arrow-rise />
            </p>

            <WebsiteVisitsChartComponent />
        </div> --}}

        <ul class="sidebar-links">
            <li class="sidebar-link logout">
                <a href="javascript:;" onclick="document.getElementById('logoutForm').submit()">
                    <i class="iconsax" icon-name="logout-2"></i> <span class="sidebar-link__text">تسجيل الخروج</span>
                </a>

                <form action="{{ route($routePrefix.'.logout') }}" method="POST" id="logoutForm">@csrf</form>
            </li>
        </ul>
    </div>
</div>
