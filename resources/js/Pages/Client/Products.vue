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
                                <div class="tree_menu">
                                    <TreeMenu :categories="productCategories" path="/pc/"
                                        :nameRoute="'Client.ProductCategory.Products'" />
                                </div>
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
                        <div class="">
                            <div class="lg:flex block justify-between items-center gap-4 text-black">
                                <h2 class="font-bold py-2 px-3 lg:text-4xl text-2xl uppercase">{{ seo.title }}</h2>
                                <div class="px-3">
                                    <form class=" flex justify-end gap-1 items-center" :action="baseUrl">
                                        <input name="s" v-model="search"
                                            class="py-2 px-6 focus:border-primary  placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary  bg-white text-black w-full lg:w-64"
                                            type="text" placeholder="Tìm kiếm tên hoặc mã sản phẩm">
                                        <button class="py-2 px-6 bg-red-500  text-white" type="submit">
                                            SEARCH
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="lg:m-2 mb-2">
                            <div class="grid lg:grid-cols-3 grid-cols-1 gap-5" v-if="products.data.length > 0">
                                <div v-for="(item, index) in products.data" class="col-span-1">
                                    <ProductItem :item="item" />
                                </div>

                            </div>
                            <div v-else>
                                <h5 class="text-center mt-16">Không tìm thấy sản phẩm</h5>
                            </div>
                        </div>
                        <div class="text-black  mt-10" v-if="products.data.length > 0">
                            <Pagination :links="products.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>

</template>
<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { Link, usePage } from '@inertiajs/vue3';
import Breadcrumb from "@/Components/Client/BreadCrumb.vue";
import ProductItem from "@/Components/Client/ProductItem.vue";
import TreeMenu from "@/Components/Client/TreeMenu.vue";
import Pagination from "@/Components/Client/Pagination.vue"; // Import component Pagination
import { ref } from "vue";
import DialogModal from "@/Components/DialogModal.vue";
const page = usePage();
const url = window.location.href;

// Tách phần domain và đường dẫn
const baseUrl = url.split('?')[0];
const params = new URLSearchParams(window.location.search);
const search =ref('');
 search.value = params.get('s');

defineProps({
    seo: { type: Object, default: {} },
    products: { type: Object, default: {} },
    productCategories: { type: Object, default: {} },
    brands: { type: Object, default: {} },
    breadcrumbs: { type: Array, default: [] }
});

const modal = ref({
    isModal: false,
    title: '',
    content: ''
});
const showModal = (type) => {
    modal.value = { isModal: true, type: type }
}
</script>

<style></style>
