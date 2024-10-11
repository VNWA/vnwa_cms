<template>
    <div>
        <AppLayout title="Appearance" :isLoading="isPageLoading">

            <template #header>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appearance
                        </h2>
                    </div>
                    <div>
                        <HeaderBreadcrumbs :breadcrumbs="[['Appearance', route('Appearance')]]" />
                    </div>
                </div>
            </template>

            <div class="p-5">
                <div class="flex items-center justify-start flex-wrap gap-5">
                    <Link :href="route('Appearance.Logo')">
                    <div
                        class="px-10 py-5 text-center border-black bg-purple-600/90 hover:bg-purple-900 cursor-pointer rounded-md shadow-md font-bold text-xl text-white">
                        Logo
                    </div>
                    </Link>
                    <Link :href="route('Appearance.Footer')">
                    <div
                        class="px-10 py-5 text-center border-black bg-purple-600/90 hover:bg-purple-900 cursor-pointer rounded-md shadow-md font-bold text-xl text-white">
                        Footer Content
                    </div>
                    </Link>
                    <Link :href="route('Appearance.TopNav')">
                    <div
                        class="px-10 py-5 text-center border-black bg-purple-600/90 hover:bg-purple-900 cursor-pointer rounded-md shadow-md font-bold text-xl text-white">
                        Top Nav Link
                    </div>
                    </Link>
                    <!-- <Link :href="route('Appearance.BotSearch')">
                    <div
                        class="px-10 py-5 text-center border-black bg-purple-600/90 hover:bg-purple-900 cursor-pointer rounded-md shadow-md font-bold text-xl text-white">
                        BotSearch
                    </div>
                    </Link> -->
                    <Link :href="route('Appearance.Profile')">
                    <div
                        class="px-10 py-5 text-center border-black bg-purple-600/90 hover:bg-purple-900 cursor-pointer rounded-md shadow-md font-bold text-xl text-white">
                        Profile
                    </div>
                    </Link>
                    <Link :href="route('Appearance.About')">
                    <div
                        class="px-10 py-5 text-center border-black bg-purple-600/90 hover:bg-purple-900 cursor-pointer rounded-md shadow-md font-bold text-xl text-white">
                        About
                    </div>
                    </Link>
                </div>
            </div>

        </AppLayout>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import HeaderBreadcrumbs from '@/Components/HeaderBreadcrumbs.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';

const isPageLoading = ref(false)


</script>

<style></style>
