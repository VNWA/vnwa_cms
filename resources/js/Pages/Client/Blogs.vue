<template>
    <div>
        <DefaultLayout :seo="seo">

            <div class="">
                <div class="container px-4 lg: lg:max-w-screen-xl mx-auto">
                    <Breadcrumb :breadcrumbs="breadcrumbs" />
                    <div class="grid lg:grid-cols-12 gap-4 mt-5">
                        <div class="lg:col-span-3 hidden lg:block">
                            <div class="shadow shadow-black/50 mb-5">
                                <div class="bg-primary p-2 text-xl text-white  font-bold">
                                    Danh mục bài viết
                                </div>
                                <div class="pe-3 ps-8 py-3">
                                    <div class="tree_menu">
                                        <TreeMenu :categories="blogCategories" path="/blogs/"
                                            :nameRoute="'Client.BlogCategory.Posts'" />
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="lg:col-span-9">
                            <h2 class="font-bold py-2 text-4xl uppercase">{{ seo.title }}</h2>
                            <div class="lg:m-2 mb-2">
                                <div class="grid lg:grid-cols-3 grid-cols-2 gap-5">
                                    <div class="col-span-1" v-for="(item, index) in blogPosts" :key="index">
                                        <div class="shadow-2xl shadow-black p-3">
                                            <div>
                                                <Link :href="route('Client.BlogPost.Detail', item.slug)">
                                                <img :src="item.image" :alt="item.name">
                                                </Link>
                                            </div>
                                            <div>
                                                <Link :href="route('Client.BlogPost.Detail', item.slug)">
                                                <h3 class="hover:text-subPrimary text-xl font-bold">
                                                    {{ item.name }}
                                                </h3>
                                                </Link>
                                            </div>
                                            <div>
                                                <Link :href="route('Client.BlogPost.Detail', item.slug)">
                                                <h5 class="text-sm ">
                                                    {{ item.desc }}
                                                </h5>
                                                </Link>
                                            </div>

                                        </div>
                                    </div>

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
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import Breadcrumb from "@/Components/Client/BreadCrumb.vue";
import EditorRenderHtml from "@/Components/Client/EditorRenderHtml.vue";
import TreeMenu from "@/Components/Client/TreeMenu.vue";
defineProps({
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
    blogPosts: {
        type: Object,
        default: {},
    },

});

</script>

<style></style>
