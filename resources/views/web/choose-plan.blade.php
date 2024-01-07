@extends('web.layouts.master')
@section('content')
<section>
    <div class="container">
        <div class="text-end pt-3 pt-md-5 pb-3">
            <router-link to="/" class="link-blue fs-5">الرئيسية <ion-icon name="chevron-forward-outline"></ion-icon></router-link>
        </div>

         <!-- Start : subscription heading -->
         <div class="mb-5">
            <h1 class="main-blue" data-aos="fade-up" data-aos-delay="300">الاشتراك</h1>
            <p data-aos="fade-up" data-aos-delay="400">لوريم ايبسوم هو نموذج افتراضي يوضع في التصاميم لتعرض على العميل.</p>
        </div>
        <!-- End : subscription heading -->

        @include('web.includes.plans-list')
    </div>
</section>

@include('web.layouts.partials.secondary-footer')
@endsection
