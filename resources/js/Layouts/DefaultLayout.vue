<template>
    <div>
        <div id="top-banner">
            <div height="56" class="css-ymtqaj">
                <picture>
                    <source
                        srcset="https://lh3.googleusercontent.com/3YjSsl02BY5KU6N2VEenV-RWYekzoP9qKd5AMYVXQOrfQCdfAS1ihDtpHU59EpuvgDBStvLcbkcgF_A0fwAB2-K3BHM1r2w=w1920-rw"
                        type="image/webp">
                    <source
                        srcset="https://lh3.googleusercontent.com/3YjSsl02BY5KU6N2VEenV-RWYekzoP9qKd5AMYVXQOrfQCdfAS1ihDtpHU59EpuvgDBStvLcbkcgF_A0fwAB2-K3BHM1r2w=w1920"
                        type="image/png"><img class="lazyload css-o4eu2v" alt=""
                        src="https://lh3.googleusercontent.com/3YjSsl02BY5KU6N2VEenV-RWYekzoP9qKd5AMYVXQOrfQCdfAS1ihDtpHU59EpuvgDBStvLcbkcgF_A0fwAB2-K3BHM1r2w=w1920-rw"
                        loading="lazy" decoding="async">
                </picture>
            </div>
        </div>
        <nav id="top-nav" class="w-full h-20">
            <ul class="px-3 gap-5 max-w-screen-lg mx-auto">
                <li v-for="(item, index) in data.top_nav" :key="index">
                    <a :href="item.link" target="_blank" rel="noopener noreferrer" class="hover:text-white/80">
                        <div class=" flex items-center justify-between gap-2">
                            <icon v-if="item.icon" :icon="item.icon" />
                            <h5 class="text-sm">
                                {{ item.name }}
                            </h5>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
        <header class="shadow-md  sticky top-0 bg-white">
            <div class="bg-white flex items-center py-5 h-full max-w-screen-lg mx-auto">
                <div class="grid grid-cols-12 gap-4 w-full items-center ">
                    <div class="col-span-8">
                        <div class="flex items-center justify-start w-full max-w-full">
                            <div class="flex items-center justify-start gap-2">
                                <Link href="/">
                                <div id="logo" :class="[
                                    'h-[35px]',
                                    'transition-all',
                                    'duration-300',
                                    'ease-in-out',
                                    isButtonShowMenu ? 'showIcon' : '',
                                    isButtonShowMenu ? 'w-[35px]' : 'w-[251px]'
                                ]" class="transition duration-700 ease-in-out">
                                    <img class="logo_icon" v-if="isButtonShowMenu" width="35" height="35"
                                        :src="data.logo.logo_icon" alt="Logo Icon">
                                    <img class="logo_full" v-else width="251" height="35" :src="data.logo.logo_full"
                                        alt="Logo Full">
                                </div>

                                </Link>
                                <button v-if="isButtonShowMenu" @click="isShowMenu = !isShowMenu"
                                    class="flex items-center justify-start gap-5 border text-gray-500/80  rounded-md h-[35px] w-full px-3 cursor-pointer hover:bg-black/5">
                                    <icon :icon="['fas', 'fa-bars']" />
                                    <h3 class="text-nowrap text-sm font-medium">Category Product</h3>
                                </button>
                            </div>

                            <div class="w-full px-3  overflow-hidden pt-7  ">
                                <div class="relative">
                                    <form action="" method="GET" class="w-full">
                                        <input type="text"
                                            class=" w-full px-3 py-3 text-sm  rounded-md bg-slate-500/10 border-black/10"
                                            placeholder="Enter the keyword you want to search for">
                                        <button type="submit"
                                            class="absolute top-0 right-0 w-12  text-xl h-full text-gray-500">
                                            <icon :icon="['fas', 'magnifying-glass']" />
                                        </button>
                                    </form>
                                </div>
                                <div class=" ">
                                    <p class="whitespace-nowrap max-w-full overflow-hidden text-ellipsis">
                                        <a v-for="(item, index) in data.bot_search" :key="index" :href="item.link"
                                            target="_blank" rel="noopener noreferrer"
                                            class="text-gray-500/90 text-xs hover:text-black/80 font-normal leading-normal border-none mt-3">
                                            <span v-if="index > 0">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                            {{ item.name }}
                                        </a>
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div
                            class="w-full max-w-full flex items-center gap-5 justify-between text-gray-500 font-medium">
                            <div class="">
                                <Link href="/" class="hover:text-main-color">
                                <div class="flex h-full items-center gap-2">
                                    <icon :icon="['far', 'circle-user']" class="text-3xl" />
                                    <div class="text-xs ">
                                        <h5>Login</h5>
                                        <h5>Register</h5>
                                    </div>
                                </div>
                                </Link>
                            </div>
                            <div class="">
                                <Link href="/" class="hover:text-main-color">
                                <div class="flex h-full items-center">
                                    <icon :icon="['far', 'bell']" class="text-3xl" />
                                </div>
                                </Link>
                            </div>

                            <div class="">
                                <Link href="/" class="hover:text-main-color">
                                <div class="flex h-full items-center gap-2">
                                    <icon :icon="['fas', 'cart-shopping']" class="text-3xl" />
                                    <div class="text-xs ">
                                        <h5>My Cart</h5>
                                        <h5 class="font-normal">(0) products</h5>
                                    </div>
                                </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class=" fixed  w-full h-full top-[122px] z-50 bg-black/50" v-if="isShowMenu && isButtonShowMenu"
            @click="isShowMenu = false">

            <div class="w-full h-full ">
                <div class="max-w-screen-lg mx-auto">
                    <div class="grid grid-cols-12">
                        <!-- Danh mục sản phẩm bên trái -->
                        <div class="col-span-4">
                            <div class="bg-white  rounded-b-md  py-2">
                                <ul class="text-sm font-medium">
                                    <li v-for="(item, index) in data.productCategories" :key="index">
                                        <Link href="/">
                                        <div @mouseenter="showContent(item.id)" @mouseleave="hideContentWithDelay"
                                            class="px-5 py-2 mb-1 text-sm cursor-pointer"
                                            :class="{ 'bg-gray-100': currentContent === item.id }">

                                        </div>
                                        <div class="flex items-center jusitfy-center gap-2">
                                            <div v-if="item.icon && item.image === null">
                                                <icon :icon="item.icon" class="text-gray-500 text-xl " />
                                            </div>
                                            <div v-if="item.image">
                                                <img :src="item.image" width="25" height="25"
                                                    alt="Product Category Image">
                                            </div>
                                            <h5>{{ item.name }}</h5>
                                        </div>
                                        </Link>

                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Nội dung sản phẩm bên phải -->
                        <div class="col-span-8">
                            <div v-for="(item, index) in data.productCategories" :key="index"
                                @mouseenter="clearHideTimeout" @mouseleave="hideContentWithDelay"
                                v-show="currentContent === item.id && item.children.length > 0">
                                <div class="child bg-white min-h-full py-2 px-5">
                                    <ul>
                                        <li v-for="(child, childIndex) in item.children" :key="childIndex">
                                            {{ child.name }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <main class="">
            <slot />
        </main>
        <footer class="w-full">
            <div class="bg-black/80">
                <div class=" max-w-screen-lg mx-auto py-5">
                    <ul class=" flex items-start  justify-between flex-wrap gap-4 ">
                        <li v-for="(item, index) in data.footer.footer_sidebar" :key="index">
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
                                    <ul class="flex items-center justify-start gap-2">
                                        <li>
                                            <Link href="/">
                                            <div
                                                class="w-8 h-8 border border-white/50 flex items-center justify-center bg-black">
                                                <icon :icon="['fab', 'fa-facebook']" class="text-md text-white" />
                                            </div>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link href="/">
                                            <div
                                                class="w-8 h-8 border border-white/50 flex items-center justify-center bg-black">
                                                <icon :icon="['fab', 'fa-facebook']" class="text-md text-white" />
                                            </div>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link href="/">
                                            <div
                                                class="w-8 h-8 border border-white/50 flex items-center justify-center bg-black">
                                                <icon :icon="['fab', 'fa-facebook']" class="text-md text-white" />
                                            </div>
                                            </Link>
                                        </li>
                                        <li>
                                            <Link href="/">
                                            <div
                                                class="w-8 h-8 border border-white/50 flex items-center justify-center bg-black">
                                                <icon :icon="['fab', 'fa-facebook']" class="text-md text-white" />
                                            </div>
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-9">
                            <div v-html="data.footer.footer_bottom" class="text-xs font-normal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';
const currentContent = ref(null);
const hideTimeout = ref(null);
const isButtonShowMenu = ref(false);
const isShowMenu = ref(false);
const showContent = (id) => {
    clearTimeout(hideTimeout.value);
    currentContent.value = id;
};

const hideContentWithDelay = () => {
    hideTimeout.value = setTimeout(() => {
        currentContent.value = null;
    }, 50); // Độ trễ 200ms trước khi ẩn nội dung
};

const clearHideTimeout = () => {
    clearTimeout(hideTimeout.value);
};
const handleScroll = () => {
    isButtonShowMenu.value = window.scrollY > 98;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
});
const data = ref({
    top_nav: [],

    logo: {
        favicon: '',
        logo_full: '',
        logo_icon: ''
    },
    bot_search: [],
    footer: {
        footer_sidebar: [],
        footer_bottom: '',

    }
});
const loadDataLayout = () => {
    axios.get('/api/load-data-layout')
        .then(response => {
            data.value = response.data

        })
        .catch(error => {
            console.log(error);
        });
}

loadDataLayout();
</script>

<style scoped>
header {
    height: 122px;
}

/*
header #logo {
    height: 35px;
    width: 251px;
} */

header #logo .logo_icon {
    display: none;
}

header #logo .logo_full {
    display: block;
}


/* header #logo.showIcon {
    height: 35px;
    width: 35px;
} */

header #logo.showIcon .logo_icon {
    display: block;
}

header #logo.showIcon .logo_full {
    display: none;
}

header #logo .logo_full {
    height: 35px;
    width: 251px;
}

header #logo .logo_icon {
    height: 35px;
    width: 35px;
}
</style>
