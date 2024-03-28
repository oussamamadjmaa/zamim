@props(['logoText'=>'صوت المدرسة'])
<div {{ $attributes->merge([]) }}>
    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" style="max-height: 66px;">
</div>
