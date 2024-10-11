<template>
    <div>
        <DefaultLayout :seo="seo">
            <div class="container px-4 lg:max-w-screen-xl mx-auto my-4">
                <div class="mb-3">
                    <Breadcrumb :breadcrumbs="breadcrumbs" />
                </div>
                <div class="grid lg:grid-cols-12 gap-4">
                    <div class="lg:col-span-3 hidden lg:block">
                        <div class="shadow shadow-black/50 mb-5">
                            <div class="bg-primary p-2 text-xl text-white  font-bold">
                                Danh mục bài viết
                            </div>
                            <div class="pe-3 ps-8 py-3">
                                <TreeMenu :categories="blogCategories" path="/blogs/"
                                    :nameRoute="'Client.BlogCategory.Posts'" />
                            </div>
                        </div>

                    </div>
                    <div class="lg:col-span-9">
                        <div class="bg-white shadow p-8">

                            <EditorRenderHtml :content="blogPost.content" />
                        </div>

                    </div>
                </div>

            </div>
        </DefaultLayout>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import TreeMenu from '@/Components/Client/TreeMenu.vue';
import Breadcrumb from '@/Components/Client/Breadcrumb.vue';
import { Link, usePage } from '@inertiajs/vue3';
import EditorRenderHtml from '@/Components/Client/EditorRenderHtml.vue';
const page = usePage();
const props = defineProps({
    seo: {
        type: Object,
        default: {},
    },
    breadcrumbs: {
        type: Array,
        default: [],
    },
    blogCategories: {
        type: Object,
        default: {},
    },
    blogPost: {
        type: Object,
        default: {},
    },
});
const thumbsSwiper = ref(null);

const showForm = ref(false);
const formData = ref({
    name: '',
    email: '',
    phone: '',
    message: '',
});



const currentTab = ref('tech_info');

const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
};
const modules = [FreeMode, Navigation, Thumbs];

const submitForm = () => {
    console.log('Form data:', formData.value);
    showForm.value = false; // Ẩn form sau khi gửi
};


</script>

<style>
.swiper {
    width: 100%;
    height: 300px;
    margin-left: auto;
    margin-right: auto;
}

.mySwiper2 {
    height: 80%;
    width: 100%;
}

.mySwiper {
    height: 20%;
}

.mySwiper .swiper-slide {
    width: 25%;
    height: 100%;
    opacity: 0.7;
    cursor: pointer;
}

.mySwiper .swiper-slide-thumb-active {
    opacity: 1;
}

.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
