@props(['logoText'=>'صوت المدرسة'])
<div {{ $attributes->merge(['class' => 'logo']) }}>
    <ion-icon name="radio-outline"></ion-icon>
    <span>{{ $logoText }}</span>
</div>
