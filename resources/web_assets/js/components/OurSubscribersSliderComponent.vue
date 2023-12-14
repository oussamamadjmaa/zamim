<template>
    <swiper
            dir="rtl"
            :spaceBetween="10"
            :grabCursor= "true"
            :centeredSlides= "true"
            :slidesPerView= "'auto'"
            :preventClicks="false"
            :preventClicksPropagation= "false"
            :initialSlide="1"
            :pagination="{
                clickable: false,
                }"
            :navigation="false"
            class="mySwiper">
        <swiper-slide>
            <div class="subscriber-card">
                <div class="subscriber-image">
                    <div class="subscriber-image__holder">
                        <img src="../../images/slider3.jpeg" alt="">
                    </div>
                </div>
                <div class="subscriber-info d-flex align-items-center py-3 px-2">
                    <div class="subscriber-avatar">
                        <div class="subscriber-avatar__holder">
                            <img src="../../images/school-avatar.jpeg" alt="">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-grow-1 justify-content-between">
                        <div class="subscriber-name">الإذاعة المدرسية رقم 1</div>
                        <div class="students-count">120 طالبا مشتركا</div>
                    </div>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="subscriber-card">
                <div class="subscriber-image">
                    <div class="subscriber-image__holder">
                        <img src="../../images/slider2.jpeg" alt="">
                    </div>
                </div>
                <div class="subscriber-info d-flex align-items-center py-3 px-2">
                    <div class="subscriber-avatar">
                        <div class="subscriber-avatar__holder">
                            <img src="../../images/school-avatar.jpeg" alt="">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-grow-1 justify-content-between">
                        <div class="subscriber-name">الإذاعة المدرسية رقم 1</div>
                        <div class="students-count">120 طالبا مشتركا</div>
                    </div>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide>
            <div class="subscriber-card">
                <div class="subscriber-image">
                    <div class="subscriber-image__holder">
                        <img src="../../images/slider1.jpeg" alt="">
                    </div>
                </div>
                <div class="subscriber-info d-flex align-items-center py-3 px-2">
                    <div class="subscriber-avatar">
                        <div class="subscriber-avatar__holder">
                            <img src="../../images/school-avatar.jpeg" alt="">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-grow-1 justify-content-between">
                        <div class="subscriber-name">الإذاعة المدرسية رقم 1</div>
                        <div class="students-count">120 طالبا مشتركا</div>
                    </div>
                </div>
            </div>
        </swiper-slide>
    </swiper>
</template>
<script>
// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
};
</script>
