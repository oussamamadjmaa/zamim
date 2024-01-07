@isset($plans)

<!-- Start : subscription plans -->
<div class="subscription-plans row mx-0">
    @foreach ($plans as $plan)
    <div class="col-md-6 mb-4">
        <!-- Start : subscription plan card -->
        <div class="subscription-plan" data-aos="fade-up" data-aos-delay="300">
            <div class="subscription-plan__heading">
                <div class="d-flex">
                    <h5 class="plan-period">
                        <x-icons.relume /><br>
                        <span>@lang($plan['name'])</span>
                    </h5>
                    <h2 class="plan-price">{{ number_format($plan['price'], 0) }}<span class="currency"> @lang($plan['currency'])</span></h2>
                </div>
                <p class="plan-brief">@lang($plan['short_description'])</p>
            </div>
            <hr class="my-4">
            <div class="subscription-plan__features">
                <p>{{ $plan['features']->{0} }}</p>
                <ul class="plan-features m-0 list-unstyled mb-4 p-0">
                    @foreach ($plan['features'] as $featureTitle => $feature)
                    @if (is_numeric($featureTitle))
                        @continue
                    @endif
                    <li class="plan-feature-item">
                        <span class="fs-5">{{ $featureTitle }}</span>
                        @if (is_array($feature))
                        <ul class="list-unstyled mb-3 ps-3">
                            @foreach ($feature as $featureSecTitle)
                            <li> <ion-icon name="checkmark-outline" class="me-2"></ion-icon> {{ $featureSecTitle }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            <a href="{{ route('school.register', ['plan' => $plan->key]) }}" class="button-main button-rounded w-100">اشترك الآن</a>
        </div>
        <!-- End : subscription plan card -->
    </div>
    @endforeach
</div>
<!-- End : subscription plans -->
@endisset

