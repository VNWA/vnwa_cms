<template>
    <div>
        <DefaultLayout :seo="seo" :isLoading="isLoading">
            <div class="container px-4 lg:max-w-screen-xl mx-auto my-4 text-black/80">
                <div class="mb-3">
                    <Breadcrumb :breadcrumbs="breadcrumbs" />
                </div>
                <div class="grid lg:grid-cols-12">
                    <div class="lg:col-span-3 hidden lg:block">
                        <div class="mb-5">
                            <form class=" flex justify-end gap-1 items-center" :action="route('Client.Products')">
                                <input name="s"
                                    class="py-2 px-6 focus:border-primary  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary  bg-white text-black w-full lg:w-full"
                                    type="text" placeholder="Tìm kiếm tên hoặc mã sản phẩm">
                                <button class="py-2 px-6 bg-red-500  text-white" type="submit">
                                    SEARCH
                                </button>
                            </form>
                        </div>
                        <div class="shadow shadow-black/50 mb-5">
                            <div class="bg-primary p-2 text-xl text-white  font-bold">
                                Danh mục sản phẩm
                            </div>
                            <div class="pe-3 ps-8 py-3">
                                <TreeMenu :categories="productCategories" path="/pc/"
                                    :nameRoute="'Client.ProductCategory.Products'" />
                            </div>
                        </div>
                        <div class="shadow shadow-black/50">
                            <div class="bg-primary p-2 text-xl  font-bold text-white">
                                Thương hiệu
                            </div>
                            <div class="pe-3 ps-8 py-3">
                                <ul class="space-y-2 text-black/80">
                                    <li v-for="(item, index) in brands" :key="index" class="list-disc">
                                        <div class="flex items-center justify-between mt-1">
                                            <Link :href="route('Client.Brand.Products', item.slug)">
                                            <h3 class="uppercase font-bold hover:text-subPrimary"
                                                :class="{ 'text-subPrimary': page.url == '/pb/' + item.slug }">
                                                {{
                                                    item.name }}</h3>
                                            </Link>

                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-9">
                        <div class="px-5">

                            <div class="grid grid-cols-12 mt-4 gap-5">
                                <div class="md:col-span-7 col-span-12">
                                    <div class="flex">
                                        <div class="w-full">
                                            <swiper :pagination="false" :loop="true" :spaceBetween="10"
                                                :thumbs="{ swiper: thumbsSwiper }" :modules="modules" class="mySwiper2">
                                                <swiper-slide v-for="(image, index) in product.images" :key="index">
                                                    <img width="640" height="640" :src="image" />
                                                </swiper-slide>
                                            </swiper>
                                            <div class="mt-3">
                                                <swiper @swiper="setThumbsSwiper" :loop="true" :spaceBetween="10"
                                                    :slidesPerView="5" :freeMode="true" :watchSlidesProgress="true"
                                                    :modules="modules" class="mySwiper">
                                                    <swiper-slide v-for="(image, index) in product.images" :key="index">
                                                        <img width="204" height="208" :src="image" />
                                                    </swiper-slide>
                                                </swiper>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:col-span-5 col-span-12">

                                    <div class="ps-3">
                                        <h1 class="text-4xl font-bold">
                                            {{ product.name }}
                                        </h1>
                                        <div class="text-primary text-2xl">
                                            Mã sản phẩm: {{ product.sku }}
                                        </div>
                                        <div class="my-4">
                                            <div class="">
                                                <div class="text-xl mb-3">
                                                    <b class="text-xl">Tình trạng hàng: </b>Còn hàng
                                                </div>
                                                <div class="text-xl mb-3">
                                                    <b class="text-xl">Xuất xứ:</b> {{ product.origin }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="font-bold text-2xl my-3">Mô tả sản phẩm
                                        </div>
                                        <div class="my-3">
                                            <EditorRenderHtml :content="product.description" />

                                        </div>
                                        <button @click="showForm = true"
                                            class="mb-2 bg-primary py-3 px-3 text-xl text-white hover:bg-subPrimary w-60 ">
                                            Liên Hệ Báo Giá
                                        </button>
                                        <div class="flex gap-2 text-lg items-center mt-5">
                                            Chia sẻ sản phẩm
                                            <icon class="text-xl" :icon="['fab', 'facebook']" />
                                            <icon class="text-xl" :icon="['fab', 'linkedin']" />
                                            <icon class="text-xl" :icon="['fab', 'square-twitter']" />
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div v-show="showForm"
                                class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                                <div class="bg-white p-6 w-full max-w-3xl relative rounded-lg">
                                    <h2 class="text-4xl text-center font-bold mb-6">BÁO GIÁ SẢN PHẨM</h2>
                                    <form @submit.prevent="submitForm">
                                        <div class="mb-4">
                                            <label class="block text-xl font-light">Họ Tên</label>
                                            <input type="text" v-model="formData.name"
                                                class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                            <InputError class="mt-2" :message="errors.name" />
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-xl font-light">Số điện thoại</label>
                                            <input type="text" v-model="formData.phone"
                                                class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                            <InputError class="mt-2" :message="errors.phone" />
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-xl font-light">Email</label>
                                            <input type="email" v-model="formData.email"
                                                class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-xl font-light">Tin nhắn</label>
                                            <textarea v-model="formData.message"
                                                class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="bg-primary text-xl text-white py-3 px-6 rounded-lg hover:bg-subPrimary transition-all">Gửi</button>
                                        </div>
                                    </form>
                                    <button @click="showForm = false"
                                        class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">
                                        <icon class="text-4xl" :icon="['fas', 'xmark']" />
                                    </button>
                                </div>
                            </div>
                            <div class="my-4">
                                <div class="flex gap-2 relative text-gray-400 ">
                                    <div class="relative">
                                        <button class=" py-4 px-6 text-2xl relative"
                                            :class="{ 'text-black': currentTab == 'tech_info' }"
                                            @click="currentTab = 'tech_info'">
                                            Thông Tin Kỹ Thuật
                                            <span
                                                class="absolute left-0 bottom-0 w-full h-1 bg-primary transform scale-x-0 transition-transform duration-300 ease-in-out"
                                                :class="{ 'scale-x-100': currentTab === 'tech_info' }">
                                            </span>
                                        </button>
                                    </div>
                                    <div class="relative">
                                        <button class=" py-4 px-6 text-2xl relative"
                                            :class="{ 'text-black': currentTab === 'catalogs' }"
                                            @click="currentTab = 'catalogs'">
                                            Catalogs
                                            <span
                                                class="absolute left-0 bottom-0 w-full h-1 bg-primary transform scale-x-0 transition-transform duration-300 ease-in-out"
                                                :class="{ 'scale-x-100': currentTab === 'catalogs' }">
                                            </span>
                                        </button>
                                    </div>
                                </div>
                                <!-- Nội dung tab -->

                                <div v-show="currentTab === 'tech_info'" class="mt-4">
                                    <EditorRenderHtml :content="product.tech_info" />
                                </div>
                                <div v-show="currentTab === 'catalogs'" class="mt-4">
                                    <ul class="grid grid-cols-4 gap-4">
                                        <li v-for="(item, index) in product.catalogs" :key="index" class="col-span-1">
                                            <a :href="item" target="_blank">
                                                <img :src="product.images[0]" :alt="product.name" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
import InputError from '@/Components/InputError.vue';
const page = usePage();
const props = defineProps({
    seo: {
        type: Object,
        default: {},
    },
    productCategories: {
        type: Object,
        default: {},
    },
    brands: {
        type: Object,
        default: {},
    },
    product: {
        type: Object,
        default: {},
    }, breadcrumbs: {
        type: Array,
        default: [],
    }
});
const thumbsSwiper = ref(null);

const showForm = ref(false);
const formData = ref({
    product_slug: props.product.slug,
    name: '',
    email: '',
    phone: '',
    message: '',
});
const errors = ref({
    name: '',
    phone: '',
})
const clearError = () => {
    errors.value = {
        name: '',
        phone: '',
    }
}
const isLoading = ref(false);
const submitForm = () => {
    clearError()
    isLoading.value = true;
    axios.post('/quote-product', formData.value).then(response => {
        toast.success(response.data.message);
        showForm.value = false;  // Ẩn form sau khi gửi

    }).catch(error => {
        toast.error(error.message, {
            autoClose: 1500,
        });
        if (error.response.data.errors) {
            const errorKeys = Object.keys(error.response.data.errors);
            errorKeys.forEach(key => {
                if (key in errors.value) {
                    errors.value[key] = error.response.data.errors[key][0]; // Lấy giá trị lỗi đầu tiên (nếu có)
                }
            });
        }
    })
    isLoading.value = false;
};


const currentTab = ref('tech_info');

const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
};
const modules = [FreeMode, Navigation, Thumbs];


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
