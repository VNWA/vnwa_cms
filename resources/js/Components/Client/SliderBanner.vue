<template>
    <swiper :pagination="{
        clickable: true,
    }" :modules="modules" class="mySwiper">
        <swiper-slide v-for="(image, index) in images" :key="index">
            <img :src="image" alt="Slide image"  width="1920" height="1132"/>
        </swiper-slide>
    </swiper>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import { Pagination } from 'swiper/modules';

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    props: {
        images: {
            type: Array,
            required: true,
        },
    },
    setup() {
        return {
            modules: [Pagination],
        };
    },
};
</script>

<style>
.swiper {
    width: 100%;
    max-height: 670px;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.swiper-pagination-bullet {
    width: 20px;
    height: 20px;
    background: #fff;
    opacity: 1;
}
.swiper-pagination-bullet:hover{
    background: red;
}
.swiper-pagination-bullet-active {
    background: red;
    /* Màu nền khi nút được chọn */
}
</style>
