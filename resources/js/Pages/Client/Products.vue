<template>
    <DefaultLayout :seo="seo">


        <div class="">
            <div class="container px-4 lg: lg:max-w-screen-xl mx-auto">
                <Breadcrumb :breadcrumbs="breadcrumbs" />
                <div class="grid lg:grid-cols-12 gap-4 mt-5">
                    <div class="lg:col-span-3 hidden lg:block">
                        <div class="shadow shadow-black/50 mb-5">
                            <div class="bg-primary p-2 text-xl text-white  font-bold">
                                Danh mục sản phẩm
                            </div>
                            <div class="pe-3 ps-8 py-3">
                                <TreeMenu :categories="productCategories" path="/pc/"
                                    :nameRoute="'Client.ProductCategory.Products'" />
                            </div>
                        </div>
                        <div class="shadow shadow-black/50">
                            <div class="bg-primary p-2 text-xl  font-bold text-white">
                                Thương hiệu
                            </div>
                            <div class="pe-3 ps-8 py-3">
                                <ul class="space-y-2 text-black/80">
                                    <li v-for="(item, index) in brands" :key="index" class="list-disc">
                                        <div class="flex items-center justify-between mt-1">
                                            <Link :href="route('Client.Brand.Products', item.slug)">
                                            <h3 class="uppercase font-bold hover:text-subPrimary"
                                                :class="{ 'text-subPrimary': page.url == '/pb/' + item.slug }">
                                                {{
                                                    item.name }}</h3>
                                            </Link>

                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>



                    </div>
                    <div class="md:hidden flex items-center justify-center w-full sticky top-[70px] z-20">
                        <button class="px-3 py-1 bg-black text-white w-full" @click="showModal('brands')">
                            Thương hiệu
                        </button>
                        <button class="px-3 py-1 bg-black text-white w-full" @click="showModal('categories')">
                            Danh mục
                        </button>
                    </div>

                    <DialogModal :show="modal.isModal" @close="modal.isModal = false">
                        <template #title>
                            <div>{{ modal.title }}</div>
                        </template>
                        <template #content>
                            <div class="">
                                <div v-if="modal.type === 'categories'">
                                    <TreeMenu :categories="productCategories" path="/pc/"
                                        :nameRoute="'Client.ProductCategory.Products'" />
                                </div>
                                <div v-else-if="modal.type === 'brands'">
                                    <ul class="space-y-2 text-black/80">
                                        <li v-for="(item, index) in brands" :key="index" class="list-disc">
                                            <div class="flex items-center justify-between mt-1">
                                                <Link :href="route('Client.Brand.Products', item.slug)">
                                                <h3 class="uppercase font-bold hover:text-subPrimary"
                                                    :class="{ 'text-subPrimary': page.url == '/pb/' + item.slug }">
                                                    {{
                                                        item.name }}</h3>
                                                </Link>

                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </template>

                        <template #footer>



                            <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4"
                                @click="modal.isModal = false">
                                Đóng
                            </button>
                        </template>
                    </DialogModal>
                    <div class="lg:col-span-9">
                        <h2 class="font-bold py-2 text-4xl uppercase">{{ seo.title }}</h2>
                        <div class="lg:m-2 mb-2">
                            <div class="grid lg:grid-cols-3 grid-cols-1 gap-5">
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

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import Breadcrumb from "@/Components/Client/Breadcrumb.vue";
import ProductItem from "@/Components/Client/ProductItem.vue";
import TreeMenu from "@/Components/Client/TreeMenu.vue";
import { ref } from "vue";
import DialogModal from "@/Components/DialogModal.vue";
const page = usePage();
defineProps({
    seo: {
        type: Object,
        default: {},
    },
    products: {
        type: Object,
        default: {},
    },
    productCategories: {
        type: Object,
        default: {},
    },
    brands: {
        type: Object,
        default: {},
    },
    breadcrumbs: {
        type: Array,
        default: [],
    }
});
const modal = ref({
    isModal: false,
    title: '',
    content: ''
})
const showModal = (type) => {
    modal.value = {
        isModal: true,
        type: type
    }
}

</script>

<style></style>
