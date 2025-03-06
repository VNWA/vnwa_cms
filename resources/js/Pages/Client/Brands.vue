<template>
    <div>
        <DefaultLayout :seo="seo" :isSlideBrands="false">

            <div class="">
                <div class="container px-4 lg: lg:max-w-screen-xl mx-auto">
                    <Breadcrumb :breadcrumbs="breadcrumbs" />
                    <div class="grid lg:grid-cols-12 gap-4 mt-5">
                        <div class="col-span-3" v-for="(item, index) in brands" :key="index">
                            <Link :href="route('Client.Brand.Products', item.slug)">
                            <img :src="item.image" class="w-full h-auto" width="200" :alt="item.name">
                            </Link>
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
defineProps({
    seo: {
        type: Object,
        default: {},
    },
    breadcrumbs: {
        type: Array,
        default: [],
    },
    brands: {
        type: Object,
        default: {},
    },
});

</script>

<style></style>
