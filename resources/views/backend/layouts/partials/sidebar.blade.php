<div class="main-sidebar">
    <div class="logo-container">
        <a href="/"><x-logos.frontend-logo class="logo-dark" /></a>
    </div>

    <div class="sidebar-content">
        <ul class="sidebar-links">
            @foreach ($sidebarLinks as $sidebarLink)
                @if (!$sidebarLink['has-access'])
                    @continue
                @endif
            <li class="sidebar-link">
                <a href="{{ $sidebarLink['link'] }}" class="@if ($sidebarLink['is-active']) router-link-active @endif">
                    <i class="iconsax" icon-name="{{ $sidebarLink['icon'] }}"></i> <span class="sidebar-link__text">{{ $sidebarLink['title'] }}</span>
                </a>
            </li>
            @endforeach
        </ul>

        @if ($routePrefix == 'admin')
        <div class="website-visits-graph-box">
            <h6 class="h10">@lang('Website Visits')</h6>
            <p></p>
            <div class="website-visits-chart__container">
                <chartjs-component stats_url="{{ route('admin.stats', ['visits', 'periodValue']) }}" type="line" version="1" :box="false"></chartjs-component>
            </div>

        </div>
        @endif

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
