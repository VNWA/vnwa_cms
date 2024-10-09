<template>
    <DefaultLayout :seo="seo">

        <div class="">
            <div class="container px-4 lg: lg:max-w-screen-xl mx-auto">
                <BreadCrumb />
                <div class="grid lg:grid-cols-12 gap-4 mt-5">
                    <div class="lg:col-span-3 hidden lg:block">
                        <div class="shadow shadow-black/50 mb-5">
                            <div class="bg-primary p-2 text-xl  font-bold">
                                Danh mục sản phẩm
                            </div>
                            <div class="pe-3 ps-8 py-3">
                                <TreeMenu :categories="productCategories" />
                            </div>
                        </div>
                        <div class="shadow shadow-black/50">
                            <div class="bg-primary p-2 text-xl  font-bold">
                               Thương hiệu
                            </div>
                            <div class="pe-3 ps-8 py-3">
                                <TreeMenu :categories="productCategories" />
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-9">
                        <h2 class="font-bold py-2 text-4xl uppercase">{{ seo.title }}</h2>
                        <div class="lg:m-2 mb-2">
                            <div class="grid lg:grid-cols-3 grid-cols-2 gap-5">
                                <div v-for="(item, index) in products" class="col-span-1">
                                    <ProductItem :item="item" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>

</template>

<script lang="ts" setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import BreadCrumb from "@/Components/Client/BreadCrumb.vue";
import ProductItem from "@/Components/Client/ProductItem.vue";
import TreeMenu from "@/Components/Client/TreeMenu.vue";

defineProps({
    seo: {
        type: Object,
        default: {},
    },
    products: {
        type: Object,
        default: {},
    },
    productCategories: Object
});




</script>

<style></style>
