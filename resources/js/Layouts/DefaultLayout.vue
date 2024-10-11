<template>

    <Head>
        <title>{{ seo.title }}</title>
        <meta name="title" :content="seo.meta_title">
        <meta name="description" :content="seo.meta_description">
        <meta name="keywords" :content="seo.meta_keywords">
        <meta name="image" :content="seo.meta_image">
        <meta property="og:type" content="website">
        <meta property="og:title" :content="seo.meta_title">
        <meta property="og:description" :content="seo.meta_description">
        <meta property="og:image" :content="seo.meta_image">
    </Head>
    <div class="flex flex-col min-h-screen">
        <header class="shadow-xl shadow-black/10"
            :class="['fixed top-0 right-0 w-full  z-50 transition-all duration-300', { 'bg-black/90': isScrolled, 'bg-transparent': !isScrolled }]">
            <div class="h-[80px] lg:h-[135px]">
                <div class="max-w-screen-xl mx-auto h-full">
                    <div class="lg:flex justify-end items-center pt-4 mb-4 gap-4 lg:mb-0 hidden">
                        <a v-for="item in layout.topNav" :key="item"
                            :class="{ 'text-white': isScrolled, 'text-black': !isScrolled }" :href="item.link">
                            <button class="flex items-center justity-center gap-1">
                                <icon :icon="item.icon" v-if="item.icon.length > 0" /> <span> {{ item.name }}</span>
                            </button>
                        </a>

                    </div>
                    <div class="lg:hidden flex items-center justify-between px-3 h-full">
                        <div class="">
                            <Link :href="route('Client.Home')">
                            <img width="360" height="37" class="max-w-52 w-auto h-auto"
                                :src="layout.logo.logo_full" />
                            </Link>

                        </div>
                        <button  @click="  isMenuOpen = !isMenuOpen">
                            <icon class="text-3xl  " :class="{ 'text-white': isScrolled, 'text-black': !isScrolled }" :icon="['fas', 'bars']" />
                        </button>
                    </div>
                    <div :class="{ 'nav-menu': true, 'active': isMenuOpen }">
                        <div class="flex lg:hidden pt-5 pr-5 justify-end" @click="  isMenuOpen = !isMenuOpen">
                            <icon class="text-3xl" :icon="['fas', 'xmark']" />
                        </div>
                        <ul class="divide-y mx-3 divide-gray-200">
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/' }">
                                <Link class="text-xl font-bold" :href="route('Client.Home')">Home</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/about-us' }">
                                <Link class="text-xl font-bold" :href="route('Client.About')">About</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/products' }">
                                <Link class="text-xl font-bold" :href="route('Client.Products')">Products</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/brands' }">
                                <Link class="text-xl font-bold" :href="route('Client.Brands')">Brands</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/blogs' }">
                                <Link class="text-xl font-bold" :href="route('Client.Blogs')">Blogs</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/contact' }">
                                <Link class="text-xl font-bold" :href="route('Client.Contact')">Contact Us</Link>
                            </li>
                        </ul>
                    </div>
                    <div class="grid lg:grid-cols-12 items-center justify-center lg:justify-between">
                        <div class="lg:col-span-5">
                            <div class="lg:block hidden">
                                <Link :href="route('Client.Home')">
                                <img width="200" height="50" class="w-auto h-24" :src="layout.logo.logo_full" />
                                </Link>
                            </div>

                        </div>
                        <div class="lg:col-span-7 hidden lg:block font-bold">
                            <ul class="lg:flex items-center justify-end gap-5 text-white ">
                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/' }">
                                    <Link class="text-lg" :href="route('Client.Home')">Home</Link>
                                </li>
                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/about-us' }">
                                    <Link class="text-lg" :href="route('Client.About')">About Us</Link>
                                </li>
                                <li class="relative  text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/products' }">
                                    <Link class="text-lg block" :href="route('Client.Products')">Products</Link>
                                    <ul class="menu-hover">
                                        <li v-for="(item, index) in productCategories" :key="index"
                                            class="border-t relative border-red-500 hover:bg-red-500 px-6 py-4">
                                            <Link :href="route('Client.Products', item.id)"> {{ item.name }}</Link>
                                            <ul class="submenu-hover" v-if="item.children.length > 0">
                                                <li class="px-6 py-4 border-t border-red-500"
                                                    v-for="(value, n) in item.children" :key="n">
                                                    <Link :href="route('Client.Products', item.id)" class=" ">{{
                                                        value.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/brands' }">
                                    <Link class="text-lg" :href="route('Client.Brands')">Brands
                                    </Link>
                                </li>

                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/blogs' }">
                                    <Link class="text-lg" :href="route('Client.Blogs')">Blogs</Link>
                                </li>
                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/contact' }">
                                    <Link class="text-lg" :href="route('Client.Contact')">Contact Us</Link>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main :class="{ 'bg-white pb-5 pt-[100px] lg:pt-[150px]': !isHome }">
            <slot />
        </main>
        <div class="mt-3" v-show="isSlideBrands">
            <div class="max-w-screen-xl mx-auto py-3 px-3">

                <swiper :slidesPerView="4" :breakpoints="{
                    '640': {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    '768': {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    '1024': {
                        slidesPerView: 10,
                        spaceBetween: 10,
                    },
                }" :autoplay="{
                    delay: 1000,
                    disableOnInteraction: false,
                }" :spaceBetween="30" :modules="swiperModule">
                    <swiper-slide v-for="(item, index) in productBrands" :key="index">
                        <div>
                            <Link :href="route('Client.Brand.Products', item.slug)">
                            <img width="100" height="100" class="w-full h-auto" :src="item.image" alt="Brand">
                            </Link>
                        </div>
                    </swiper-slide>

                </swiper>
            </div>


        </div>
        <footer class="w-full ">
            <div class="bg-black/80">
                <div class=" max-w-screen-xl mx-auto py-5 px-3">
                    <ul class=" flex items-start  justify-between flex-wrap gap-4 ">
                        <li v-for="(item, index) in layout.footer.footer_sidebar" :key="index">
                            <div>
                                <h3 class="font-bold text-base text-white mb-2 ">
                                    {{ item.name }}
                                </h3>
                                <ul class="w-full text-sm ">

                                    <li class="mb-2" v-for="(value, n) in item.value" :key="n">
                                        <Link :href="value.link" class="text-wrap ">
                                        <h3 class="text-white/50 hover:text-white/90"> {{ value.name }} </h3>
                                        </Link>
                                    </li>

                                </ul>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-black/90 text-white/60">
                <div class=" max-w-screen-xl mx-auto py-5 px-3">
                    <div class="grid grid-cols-12 gap-4 py-5">
                        <div class="lg:col-span-3 col-span-12">
                            <div class="h-full w-full flex items-center justify-center">
                                <div>
                                    <h3 class="text-xl mb-5">Connect with us
                                    </h3>
                                    <ul class="grid grid-cols-4 gap-1">
                                        <li v-for="(item, index) in layout.profile.social" :key="index"
                                            class="col-span-1">
                                            <a target="_blank" :href="item.link">
                                                <div
                                                    class="w-8 h-8 border border-white/50 flex items-center justify-center bg-black">
                                                    <icon :icon="item.icon" v-if="item.icon.length > 0"
                                                        class="text-md text-white" />
                                                </div>
                                            </a>

                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-span-9 col-span-12">
                            <div v-html="layout.footer.footer_bottom" class="text-xs font-normal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <ActionLoading v-if="isLoading" />


</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import '../../css/style.css';
import { Autoplay } from 'swiper/modules';
import ActionLoading from '@/Components/ActionLoading.vue';

const page = usePage();
const layout = page.props.layout
const productCategories = page.props.productCategories
const productBrands = page.props.brands
const swiperModule = [Autoplay];

defineProps({
    isLoading: {
        type: Boolean,
        default: false
    }, isHome: {
        type: Boolean,
        default: false
    },
    isSlideBrands: {
        type: Boolean,
        default: true
    },
    seo: {
        type: Object,
        default: () => ({
            title: 'Global Procurement Logistics Solutions Co., LTD',
            meta_title: 'Công ty TNHH Giải pháp Logistics Mua sắm Toàn cầu | Global Procurement Logistics Solutions Co., LTD',
            meta_description: 'Chúng tôi cung cấp các giải pháp logistics và mua sắm toàn cầu chuyên nghiệp, đáng tin cậy và hiệu quả. Tối ưu hóa chuỗi cung ứng với Global Procurement Logistics Solutions Co., LTD.',
            meta_keywords: 'Logistics, mua sắm toàn cầu, giải pháp logistics, Global Procurement Logistics, giải pháp chuỗi cung ứng',
        }),
    },
});

// Khai báo biến và kiểu dữ liệu
const selectedMenu = ref(null)

// Dữ liệu menu với kiểu MenuItem[]

// Hàm toggleMenu để thay đổi selectedMenu
const toggleMenu = (index) => {
    selectedMenu.value = selectedMenu.value === index ? null : index
}
const isMenuOpen = ref(false)
// -------------------------------------------------------------------
const isScrolled = ref(false); // Khởi tạo biến để theo dõi trạng thái cuộn


// Hàm để kiểm tra trạng thái cuộn
const handleScroll = () => {
    isScrolled.value = window.scrollY > 135; // Cập nhật giá trị isScrolled dựa vào vị trí cuộn
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll); // Thêm sự kiện cuộn khi component được gắn
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll); // Xóa sự kiện cuộn khi component bị hủy
});
</script>

<style></style>
