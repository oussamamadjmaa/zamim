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
        <swiper-slide v-for="subscriber in subscribers.list">
            <div class="subscriber-card">
                <div class="subscriber-image">
                    <div class="subscriber-image__holder">
                        <img :src="subscriber.cover" :alt="subscriber.name">
                    </div>
                </div>
                <div class="subscriber-info d-flex align-items-center py-3 px-2">
                    <div class="subscriber-avatar">
                        <div class="subscriber-avatar__holder">
                            <img :src="subscriber.avatar" alt="">
                        </div>
                    </div>
                    <div class="d-flex flex-wrap flex-grow-1 justify-content-between">
                        <div class="subscriber-name" v-text="subscriber.name"></div>
                        <div class="students-count"><span v-text="subscriber.students_count"></span> طالبا مشتركا</div>
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
    props: {
        subscribers: Object
    },
};
</script>
