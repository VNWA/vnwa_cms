<!-- resources/js/Components/Sidebar.vue -->
<template>
    <aside id="sidebar" :class="{ 'active': adminStore.isSidebarShow || isMobile() }"
        class="w-full p-1 bg-gray-900 text-gray-100 min-h-screen h-auto sticky ease-in duration-300">
        <div class="sidebar-header">
            <div class="logo">
                <img src="/images/vnwaLogoFull.png" class="show" alt="Vinawebapp Logo">
                <img src="/images/vnwaLogoIcon.png" class="hide" alt="Vinawebapp Logo">
            </div>
            <div class="btn" @click="adminStore.toggleSidebar" v-if="!isMobile()">
                <span class="relative inline-block overflow-hidden rounded-full p-[1px]">
                    <span
                        class="absolute inset-[-1000%] animate-[spin_2s_linear_infinite] bg-[conic-gradient(from_90deg_at_50%_50%,#E2CBFF_0%,#393BB2_50%,#E2CBFF_100%)]" />
                    <div
                        class="inline-flex h-full w-full cursor-pointer items-center justify-center rounded-full bg-slate-950/90 px-3 py-1 text-sm font-medium text-white backdrop-blur-3xl">
                        <icon icon="fa-xmark" class="show" />
                        <icon icon="fa-bars" class="hide" />
                    </div>
                </span>
            </div>
        </div>
        <div class="sidebar-content">
            <ul id="sidebar-content-list">
                <li class="mb-3 ">
                    <SideBarLink :href="route('dashboard')" :active="check('/dashboard')">
                        <icon icon="fa-home" class="mr-2" />
                        <span class="show font-semibold  text-slate-200">Dashboard</span>
                    </SideBarLink>

                </li>
                <li class="mb-3">
                    <div class=" cursor-pointer relative w-100 py-2 px-4 rounded sidebar-item-list "
                        :class="{ 'active': isBlogsActive || check('/blog') }">
                        <div class="flex items-center justify-start sidebar-item-list-title"
                            @click=" isBlogsActive = !isBlogsActive;">
                            <icon :icon="['fas', 'blog']" class="mr-2" />
                            <span class="show  font-semibold  text-slate-200">Blog</span>
                            <icon :icon="['fas', 'chevron-down']" class="ml-2 show" />
                        </div>

                        <div class="sidebar-item-list-content  mt-3">
                            <ul class=" border-l border-purple-100">
                                <li class="mb-1">
                                    <SideBarMenuItemLink :href="route('Blog.Categories')"
                                        :active="check('/blog/categories')">
                                        Categories
                                    </SideBarMenuItemLink>
                                    <SideBarMenuItemLink :href="route('Blog.Tag')" :active="check('/blog/tags')">
                                        Tags
                                    </SideBarMenuItemLink>
                                    <SideBarMenuItemLink :href="route('Blog.Post')" :active="check('/blog/posts')">
                                        Post
                                    </SideBarMenuItemLink>
                                </li>

                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
import { useAdminStore } from '@/store/admin';
import SideBarLink from './SideBarLink.vue';
import SideBarMenuItemLink from './SideBarMenuItemLink.vue';
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
const isMobile = () => {
    if (window.innerWidth <= 500) {
        return true;
    }
    else {
        return false;
    }
}
const adminStore = useAdminStore();
const check = (path) => {
    const { url } = usePage();

    if (url.includes(path)) {
        return true;
    } else {
        return false;

    }
    // return isActive;
};
const isBlogsActive = ref(false);
</script>
