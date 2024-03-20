<footer id="footer">
    @php
    $footer = $frontendContent->where('section', 'footer')->first();
    @endphp
    <div class="footer-content">
        <div class="container d-flex flex-wrap justify-content-between">
            <div class="about_" data-aos="fade-up" data-aos-delay="300">
                <x-logos.frontend-logo class="logo-dark" />
                <p>{{ $footer?->content?->description }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400">
                <h5>أقسام الموقع</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="link-white">من نحن</a></li>
                    <li><a href="{{ route('web.choose-plan') }}" class="link-white">الإشتراك</a></li>
                    <li><a href="#" class="link-white">المشتركين</a></li>
                    <li><a href="#" class="link-white">الخصوصية</a></li>
                </ul>
            </div>
            <div data-aos="fade-up" data-aos-delay="500">
                <h5>الدعم</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="link-white">تواصل معنا</a></li>
                    <li><a href="#" class="link-white">مركز المساعدة</a></li>
                    <li><a href="#faq" class="link-white">الأسئلة الشائعة</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container py-3">
            <div class="copyright-text">
                {{ $footer?->content?->copyright_text ?? '' }}
            </div>
            @if ($footer && $footer->content && $footer->content->social_media)
            <ul class="social-links list-unstyled d-flex flex-wrap">
                @foreach ($footer->content->social_media as $socialMedia)
                    <li><a href="{{ $socialMedia->url ?? '' }}" title="{{ $socialMedia->title ?? '' }}">{!! $socialMedia->icon ?? '' !!}</a></li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</footer>
