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
            <div class="h-[90px] lg:h-[135px]">
                <div class="max-w-screen-xl mx-auto">
                    <div class="lg:flex justify-end items-center pt-4 mb-4 gap-4 lg:mb-0 hidden">
                        <a v-for="item in layout.topNav" :key="item"
                            :class="{ 'text-white': isScrolled, 'text-black': !isScrolled }" :href="item.link">
                            <button class="flex items-center justity-center gap-1">
                                <icon :icon="item.icon" v-if="item.icon.length > 0" /> <span> {{ item.name }}</span>
                            </button>
                        </a>

                    </div>
                    <div class="lg:hidden flex">
                        <div class="p-5">
                            <Link :href="route('Client.Home')">
                            <img width="360" height="37" class="max-w-full h-auto" :src="layout.logo.logo_full" />
                            </Link>
                            <div class="text-primary italic text-sm">
                                Providing the Offshore Community Technical Solutions
                            </div>
                        </div>
                        <div @click="  isMenuOpen = !isMenuOpen" class="p-5">
                            <icon class="text-3xl text-white " :icon="['fas', 'bars']" />
                        </div>
                    </div>
                    <div :class="{ 'nav-menu': true, 'active': isMenuOpen }">
                        <div class="flex lg:hidden pt-5 pr-5 justify-end" @click="  isMenuOpen = !isMenuOpen">
                            <icon class="text-3xl" :icon="['fas', 'xmark']" />
                        </div>
                        <ul class="divide-y mx-3 divide-gray-200">
                            <li v-for="(item, index) in productCategories" :key="index" class="pb-2">
                                <div>
                                    <Link :href="route('Client.Home')" :class="{
                                        'text-gray-700': selectedMenu !== index
                                    }" class="block py-2 transition duration-300 ease-in-out hover:text-primary">
                                    {{ item.name }}
                                    </Link>
                                    <button @click.prevent="toggleMenu(index)">
                                        sadg
                                    </button>
                                </div>


                                <!-- Menu con hiển thị khi click -->
                                <div v-if="selectedMenu === index" class="">
                                    <ul class="p-0">
                                        <li v-for="(subItem, subIndex) in item.submenu" :key="subIndex"
                                            class="text-sm text-gray-600 hover:text-gray-800 transition duration-200">
                                            {{ subItem }}
                                        </li>
                                    </ul>
                                </div>
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
                                <li class=" text-primary hover:text-red-500 cursor-pointer"
                                    :class="{ 'text-red-500': page.url === '/' }">
                                    <Link class="text-lg" :href="route('Client.Home')">Home</Link>
                                </li>
                                <li class="relative  text-primary hover:text-red-500 cursor-pointer"
                                    :class="{ 'text-red-500': page.url === '/products' }">
                                    <Link class="text-lg block" :href="route('Client.Products')">Products</Link>
                                    <ul class="menu-hover">
                                        <li v-for="(item, index) in productCategories" :key="index"
                                            class="border-t relative border-red-500 hover:bg-red-500 px-6 py-4">
                                            <Link :href="route('Client.Documents')"> {{ item.name }}</Link>
                                            <ul class="submenu-hover" v-if="item.children.length > 0">
                                                <li class="px-6 py-4 border-t border-red-500"
                                                    v-for="(value, n) in item.children" :key="n">
                                                    <Link :href="route('Client.Documents')" class=" ">{{ value.name }}
                                                    </Link>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </li>
                                <li class=" text-primary hover:text-red-500 cursor-pointer"
                                    :class="{ 'text-red-500': page.url === 'documents' }">
                                    <Link class="text-lg" :href="route('Client.Documents')">Documents and Software
                                    </Link>
                                </li>
                                <li class=" text-primary hover:text-red-500 cursor-pointer"
                                    :class="{ 'text-red-500': page.url === '/about-us' }">
                                    <Link class="text-lg" :href="route('Client.About')">About</Link>
                                </li>
                                <li class=" text-primary hover:text-red-500 cursor-pointer"
                                    :class="{ 'text-red-500': page.url === '/contact' }">
                                    <Link class="text-lg" :href="route('Client.Contact')">Contact</Link>
                                </li>
                                <li class=" text-primary hover:text-red-500 cursor-pointer"
                                    :class="{ 'text-red-500': page.url === '/blogs' }">
                                    <Link class="text-lg" :href="route('Client.Blogs')">Blog</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div :class="{ 'bg-white pt-[80px] lg:pt-[150px]': !isHome }">
            <slot />
        </div>
        <footer class="w-full">
            <div class="bg-black/80">
                <div class=" max-w-screen-lg mx-auto py-5">
                    <ul class=" flex items-start  justify-between flex-wrap gap-4 ">
                        <li v-for="(item, index) in layout.footer.footer_sidebar" :key="index">
                            <div>
                                <h3 class="font-bold text-base text-white mb-2 ">
                                    {{ item.name }}
                                </h3>
                                <ul class="w-full text-sm text-white/50">

                                    <li class="mb-2" v-for="(value, n) in item.value" :key="n">
                                        <Link :href="value.link" class="text-wrap hover:text-white/90">
                                        <h3> {{ value.name }} </h3>
                                        </Link>
                                    </li>

                                </ul>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-black/90 text-white/60">
                <div class=" max-w-screen-lg mx-auto py-5">
                    <div class="grid grid-cols-12 gap-4 py-5">
                        <div class="col-span-3">
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
                        <div class="col-span-9">
                            <div v-html="layout.footer.footer_bottom" class="text-xs font-normal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- <footer>
            <div class="bg-bgfooter lg:py-10 pt-10">
                <div class="max-w-screen-xl mx-auto text-white">
                    <div class="p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-12">
                            <div class="lg:col-span-4">
                                <h4 class="font-bold text-xl text-grayTitle uppercase">Social</h4>
                                <div class="flex lg:mt-4 lg:mb-6 my-6 mt-4 ">
                                    <button class="border hover:bg-red-500 w-12 h-12 rounded-md mr-2">
                                        <icon class="text-2xl text-grayContent" :icon="['fab', 'facebook-f']" />
                                    </button>
                                    <button class="border hover:bg-red-500 w-12 h-12 rounded-md mr-2">
                                        <icon class="text-2xl text-grayContent" :icon="['fab', 'facebook-f']" />
                                    </button>
                                    <button class="border hover:bg-red-500 w-12 h-12 rounded-md mr-2">
                                        <icon class="text-2xl text-grayContent" :icon="['fab', 'facebook-f']" />
                                    </button>
                                    <button class="border hover:bg-red-500 w-12 h-12 rounded-md mr-2">
                                        <icon class="text-2xl text-grayContent" :icon="['fab', 'facebook-f']" />
                                    </button>
                                </div>
                                <div class="border-t border-grayContent pt-7" style="width: 360px;">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d15338.43487931804!2d108.17844570000001!3d16.033871549999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1728243447637!5m2!1svi!2s"
                                        width="360" height="250" style="border:0;" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                            <div class="lg:col-span-4">
                                <div class="lg:ml-6 mt-4 lg:mt-0">
                                    <h4 class="font-bold text-xl text-grayTitle mb-1 uppercase">Quick links</h4>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Selco USA</Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Ground Fault</Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Generator Controller
                                        </Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Flexgen</Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Potentiometer</Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Insulation Detection
                                        </Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Synchroscope</Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Arc Protection Relay
                                        </Link>
                                    </div>
                                    <div class="py-2">
                                        <Link class="text-grayContent hover:text-red-500 " :href="route('Client.Home')">
                                        Marine Alarm Panel
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-span-4">
                                <div class="lg:mr-8 my-4 lg:my-0">
                                    <h4 class="font-bold text-xl text-grayTitle my-2 lg:mb-1 uppercase">Search for
                                        Products</h4>
                                    <div class="lg:my-7 mb-7">
                                        <form action="">
                                            <input type="text"
                                                class="pl-2 py-3 w-full rounded-sm focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary"
                                                placeholder="Search...">
                                        </form>
                                    </div>
                                    <div class="border-t border-grayContent pt-7">
                                        <h6 class="text-grayContent text-sm lg:text-xl">Phone:</h6>
                                        <h6>
                                            <Link
                                                class="text-sm lg:text-xl text-grayContent hover:text-red-500 underline hover:no-underline"
                                                :href="route('Client.Home')">
                                            +1-770-455-9110</Link>
                                        </h6>
                                    </div>
                                    <div class="my-7">
                                        <h6 class="text-grayContent text-sm lg:text-xl">Phone:</h6>
                                        <h6>
                                            <Link
                                                class="text-sm lg:text-xl text-grayContent hover:text-red-500 underline hover:no-underline"
                                                :href="route('Client.Home')">
                                            4560
                                            River Bottom Drive
                                            Norcross, GA 30092
                                            USA</Link>
                                        </h6>
                                    </div>
                                    <div class="my-7">
                                        <h6 class="text-grayContent text-sm lg:text-xl">Email:</h6>
                                        <h6>
                                            <Link
                                                class="text-sm lg:text-xl text-grayContent hover:text-red-500 underline hover:no-underline"
                                                :href="route('Client.Home')">
                                            4560
                                            info@selcousa.com</Link>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-bgfooterBot">
                <div class="max-w-screen-xl mx-auto">
                    <div class="py-8 text-center lg:text-left lg:flex lg:justify-between text-grayContent">
                        <div class="pb-3 lg:pb-0">
                            Copyright © 2024 . All Rights Reserved. Our Policies
                        </div>
                        <div class=" ">
                            SELCO USA, INC. | DUNS: 86-952-7408 | CAGE code 88BF3
                        </div>
                    </div>
                </div>
            </div>
        </footer> -->
    </div>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
import '../../css/style.css';

const page = usePage();
const layout = page.props.layout
const productCategories = page.props.productCategories
defineProps({
    isHome: {
        type: Boolean,
        default: false
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
const menuItems = [
    {
        name: 'Home',
        submenu: ['Submenu 1', 'Submenu 2', 'Submenu 3']
    },
    {
        name: 'Nail Polishes',
        submenu: ['Nail Color 1', 'Nail Color 2', 'Nail Color 3']
    },
    {
        name: 'Manicure',
        submenu: ['Manicure 1', 'Manicure 2']
    },
    {
        name: 'Kits',
        submenu: ['Kit 1', 'Kit 2', 'Kit 3']
    },
    {
        name: 'Outlet',
        submenu: ['Outlet 1', 'Outlet 2']
    },
    {
        name: 'Learn With Us',
        submenu: ['Lesson 1', 'Lesson 2']
    }
]
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
