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
                                <icon v-if="item.icon && item.icon.length > 0" :icon="item.icon" /> <span> {{ item.name
                                    }}</span>
                            </button>
                        </a>

                    </div>
                    <div class="lg:hidden flex items-center justify-between px-3 h-full">
                        <div class="">
                            <Link :href="route('Client.Home')">
                            <img width="360" height="37" class="max-w-52 w-auto h-auto" :src="layout.logo.logo_full" />
                            </Link>

                        </div>
                        <button @click="  isMenuOpen = !isMenuOpen">
                            <icon class="text-3xl  " :class="{ 'text-white': isScrolled, 'text-black': !isScrolled }"
                                :icon="['fas', 'bars']" />
                        </button>
                    </div>
                    <div :class="{ 'nav-menu': true, 'active': isMenuOpen }">
                        <div class="flex lg:hidden pt-5 pr-5 justify-end" @click="  isMenuOpen = !isMenuOpen">
                            <icon class="text-3xl" :icon="['fas', 'xmark']" />
                        </div>
                        <ul class="divide-y mx-3 divide-gray-200">
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/' }">
                                <Link class="text-xl font-bold" :href="route('Client.Home')">Trang Chủ</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/ve-chung-toi' }">
                                <Link class="text-xl font-bold" :href="route('Client.About')">Về chúng tôi</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/dich-vu' }">
                                <Link class="text-xl font-bold" :href="route('Client.About')">Dịch vụ</Link>
                            </li>

                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/bai-viet' }">
                                <Link class="text-xl font-bold" :href="route('Client.Blogs')">Bài Viết</Link>
                            </li>
                            <li class=" text-primary  cursor-pointer block py-2 transition duration-300 ease-in-out mb-3"
                                :class="{ 'text-subPrimary': page.url === '/lien-he' }">
                                <Link class="text-xl font-bold" :href="route('Client.Contact')">Liên Hệ</Link>
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
                                    <Link class="text-lg" :href="route('Client.Home')">Trang chủ</Link>
                                </li>
                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/ve-chung-toi' }">
                                    <Link class="text-lg" :href="route('Client.About')">Về Chúng Tôi</Link>
                                </li>
                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/dich-vu' }">
                                    <Link class="text-lg" :href="route('Client.Service')">Dịch Vụ</Link>
                                </li>



                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/bai-viet' }">
                                    <Link class="text-lg" :href="route('Client.Blogs')">Bài Viết</Link>
                                </li>
                                <li class=" text-primary hover:text-subPrimary cursor-pointer"
                                    :class="{ 'text-subPrimary': page.url === '/lien-he' }">
                                    <Link class="text-lg" :href="route('Client.Contact')">Liên Hệ</Link>
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
        <div class="bg-white  " v-show="isSlideBrands">
            <div class="bg-teal-100/50 py-10">
                <div class="max-w-screen-xl mx-auto py-3 px-3">

                    <swiper :slidesPerView="1" :breakpoints="{
                        '640': {
                            slidesPerView: 2,
                            spaceBetween: 30,
                        },
                        '768': {
                            slidesPerView: 2,
                            spaceBetween: 30,
                        },
                        '1024': {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                    }" :autoplay="{
                        delay: 1000,
                        disableOnInteraction: false,
                    }"
                   :loop="true"
                    :spaceBetween="30" :modules="swiperModule">
                        <swiper-slide v-for="(item, index) in productBrands" :key="index">
                            <div>


                                <div
                                    class="w-full rounded-lg shadow bg-gray-800 dark:border-gray-700 py-5 min-h-[300px]">
                                    <div class="flex items-center justify-center">
                                        <div class="w-20 h-20 rounded-full overflow-hidden">
                                            <img class="rounded-t-lg" :src="item.image" alt="Chuyên Gia Hướng Nghiệp" />

                                        </div>
                                    </div>

                                    <div class="p-5">
                                        <div>
                                            <h5
                                                class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">
                                                {{ item.name }}</h5>
                                        </div>
                                        <div class="mb-3 font-normaltext-gray-400">
                                            <div v-html="item.desc"></div>
                                        </div>


                                    </div>
                                </div>


                            </div>
                        </swiper-slide>

                    </swiper>
                </div>
            </div>



        </div>



        <footer class="w-full ">

            <div id="footerBottom" :style="{
                '--footer_bottom_bg': hexToRgb(layout.footer.footer_bottom_bg),
                '--footer_bottom_color': hexToRgb(layout.footer.footer_bottom_color)
            }">
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
                                                    <img :src="item.icon_image" v-else width="20" height="20"
                                                        alt="vinawebapp.com">
                                                </div>
                                            </a>

                                        </li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="lg:col-span-5 col-span-12">
                            <div class="">
                                <div v-html="layout.footer.footer_bottom" class="space-y-2"></div>
                            </div>

                        </div>
                        <div class="lg:col-span-4 col-span-12">
                            <div id="google_map" class="relative" v-if="layout.footer.footer_map">
                                <div v-html="layout.footer.footer_map">
                                </div>
                            </div>
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
import '../../css/client.css';
import { Autoplay } from 'swiper/modules';
import ActionLoading from '@/Components/ActionLoading.vue';


const page = usePage();
const layout = page.props.layout
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
            title: 'Chinh Phục tương lai thành công',
            meta_title: 'Chinh Phục tương lai thành công | Chuyên Gia Hướng Nghiệp',
            meta_description: 'Tại đây, chúng tôi cam kết đồng hành cùng bạn trong hành trình chinh phục ước mơ, giúp bạn khám phá bản thân, đưa ra những lựa chọn đúng đắn và chuẩn bị sẵn sàng để bước vào một tương lai thành công! Nếu bạn cần tư vấn, đừng ngần ngại liên hệ. Hãy để chúng tôi giúp bạn “khơi dậy tiềm năng – định hướng tương lai',
            meta_keywords: 'Hướng nghiệp, xuất khẩu lao đông',
        }),
    },
});
const hexToRgb = (hex) => {
    if (hex) {

        const bigint = parseInt(hex.slice(1), 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
        return `${r}, ${g}, ${b}`; // Trả về "r, g, b"
    } else return `none`
};
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

<style>
#google_map iframe {
    width: 100%;
    max-height: 200px
}
</style>
<style src="@/../css/editor.css"></style>
