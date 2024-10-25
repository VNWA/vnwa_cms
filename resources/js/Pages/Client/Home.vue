<template>
    <DefaultLayout :isHome="true">

        <div>
            <SliderBanner :images="banners_image" /> <!-- Sửa lại tên prop từ src thành images -->
        </div>
        <div class="bg-red-600">
            <div class="py-7">
                <form class=" flex justify-center items-center" :action="route('Client.Products')">
                    <input name="s"
                        class="py-3 px-6 focus:border-primary rounded placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary mr-1 bg-white text-black"
                        type="text" placeholder="Search Products...">
                    <button class="py-3 px-6 bg-red-500 rounded text-white" type="submit">
                        SEARCH
                    </button>
                </form>
            </div>
        </div>
        <div style="background-color: #f9f9f9;">
            <div class="container px-4 lg: lg:max-w-screen-xl mx-auto pt-20 text-black/80">
                <div class="bg-white shadow p-8">

                    <EditorRenderHtml :content="layout.profile.short_about" />
                </div>
                <div style="">

                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script lang="ts" setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import SliderBanner from "@/Components/Client/SliderBanner.vue";
import { Head, Link, router } from '@inertiajs/vue3';
import EditorRenderHtml from "@/Components/Client/EditorRenderHtml.vue";
defineProps({
    seo: {
        type: Object,
        default: {},
    },
    banners_image: {
        type: Array,
        default: [],
    },
    layout: Object
});


</script>

<style></style>
