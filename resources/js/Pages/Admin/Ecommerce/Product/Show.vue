<template>
    <AppLayout title="Product" :isLoading="isPageLoading">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
                </div>
                <div>
                    <HeaderBreadcrumbs :breadcrumbs="[['Product', route('Ecommerce.Product')]]" />
                </div>
            </div>
        </template>

        <div class="p-2">
            <div class="grid grid-cols-12 gap-4">
                <div class="lg:col-span-12 col-span-12">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pt-8 pb-12 px-2 ">
                        <div class="flex items-center justify-between w-full mb-5">

                            <div class="">
                                <button :disabled="itemsSelected.length === 0"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs"
                                    :class="{ 'bg-red-600/60 hover:bg-red-600/60': itemsSelected.length === 0 }"
                                    @click="showisModalDeleteMutipleItem">
                                    <icon :icon="['fas', 'x']" class="mr-1" /> Clear data selection
                                </button>
                            </div>
                            <div class=" text-xs uppercase">

                                <div class="flex items-center justify-end gap-4">
                                    <button type="button" @click="isFormFilter = !isFormFilter"
                                        :class="{ 'shadow-2xl shadow-purple-500 text-purple-500': serverOptions.name || serverOptions.categories && serverOptions.categories.length > 0 || serverOptions.brands && serverOptions.brands.length > 0 }"
                                        class="bg-sky-500 uppercase border border-gray-300 font-bold text-center text-gray-100 text-sm rounded-lg block w-full py-2 px-3">
                                        <icon :icon="['fas', 'search']" />
                                        Filter
                                    </button>
                                    <Link :href="route('Ecommerce.Product.Import')"
                                        class="bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 px-2 rounded text-nowrap ">
                                    <icon :icon="['fas', 'file-import']" /> Import Excel
                                    </Link>
                                    <Link :href="route('Ecommerce.Product.Create')"
                                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded text-nowrap ">
                                    <icon :icon="['fas', 'plus']" /> Create
                                    </Link>
                                </div>
                            </div>

                        </div>
                        <div :class="{ 'max-h-0': !isFormFilter, 'max-h-screen': isFormFilter }"
                            class="overflow-hidden transition-max-height duration-500 ease-in-out">
                            <div class="px-2 py-5 shadow-md border-2 border-black  bg-purple-500/20">
                                <div class="flex items-center justify-between gap-4 mb-5">
                                    <label for="name" class="text-lg font-bold w-24 text-black/80"> Name: </label>
                                    <input type="text" v-model="serverOptions.name" id="name"
                                        class="w-full rounded-md border border-gray-400/50">
                                </div>
                                <div class="flex items-center justify-between gap-4 mb-5" v-if="brandsData.length > 0">
                                    <label for="brands" class="text-lg font-bold w-24 text-black/80"> Brands: </label>
                                    <MultiSelect id="brands" v-model="serverOptions.brands" display="chip"
                                        :options="brandsData" optionLabel="name" filter placeholder="Select brands"
                                        class="w-full py-1 px-3 overflow-hidden" />
                                </div>
                                <div class="flex items-center justify-between gap-4 mb-5"
                                    v-if="categoriesData.length > 0">
                                    <label for="categories" class="text-lg font-bold w-24 text-black/80"> Category: </label>
                                    <MultiSelect id="categories" v-model="serverOptions.categories" display="chip"
                                        :options="categoriesData" optionLabel="name" filter placeholder="Select brands"
                                        class="w-full py-1 px-3 overflow-hidden" />
                                </div>
                            </div>
                        </div>
                        <div class="my-2 ">
                            <DataTable :key="reRender" v-model:server-options="serverOptions" :headers="headers"
                                :items="items" :server-items-length="serverItemsLength" :isTableLoading="isTableLoading"
                                buttons-pagination show-index v-model:items-selected="itemsSelected">
                                <template #item-image="{ image }">
                                    <div class="py-2">
                                        <img :src="image" width="80" v-if="image" />
                                        <img src="/images/no_img.jpg" width="100" v-else />
                                    </div>
                                </template>
                                <template #item-categories="{ categories }">
                                    <div class="flex justify-start flex-wrap gap-1 p-3">

                                        <div class="" v-for="(item, index) in categories" :key="index">
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded  d border border-blue-400">
                                                {{ item.name }}
                                            </span>
                                        </div>

                                    </div>
                                </template>
                                <template #item-brand="{ brand }">
                                    <div>
                                        <div class="flex justify-start flex-wrap gap-1 p-3">

                                            <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded   border border-green-400">
                                                    {{ brand.name }}
                                                </span>
                                        </div>
                                    </div>
                                </template>
                                <template #item-name="{ name, slug }">
                                    <a :href="slug" target="_blank"
                                        class="flex items-center justify-start gap-3 text-blue-500/80 hover:text-blue-500/60">
                                        <icon :icon="['fas', 'arrow-up-right-from-square']" class="h-4" />
                                        <h5 class="text-md">{{ name }}</h5>
                                    </a>
                                </template>
                                <template #item-operation="item">
                                    <div class="flex items-center  gap-5">
                                        <Link :href="route('Ecommerce.Product.Edit', item.id)" class=" text-xl text-yellow-600">
                                        <icon :icon="['fas', 'edit']" />
                                        </Link>
                                        <button class=" text-xl text-red-500"
                                            @click="showIsModalDeleteItem(item.id, item.name)">
                                            <icon :icon="['fas', 'trash']" />
                                        </button>
                                    </div>
                                </template>

                            </DataTable>

                            <!-- Modal Delete -->
                            <DialogModal :show="isModalDelete" @close="isModalDelete = false">
                                <template #title>
                                    Xóa dữ liệu
                                </template>

                                <template #content>
                                    Chắc chắn xóa các dữ liệu này!
                                    <div class="mt-4"></div>
                                    <div v-if="itemsDelete.length > 0">
                                        <div class="flex items-center" v-for="item in itemsDelete" :key="item.id">
                                            <icon :icon="['fas', 'x']" class="text-red-600 mr-1" /> <span>{{ item.name
                                                }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 mb-1">
                                        <div class="text-xs text-gray-600">Lưu ý :
                                            <ul class="pl-4">
                                                <li class="font-bold list-disc"
                                                    style="font-family: Arial, Helvetica, sans-serif;">Các dữ liệu được
                                                    xóa sẽ tự động đưa vào thùng rác</li>
                                                <li class="font-bold list-disc"
                                                    style="font-family: Arial, Helvetica, sans-serif;">Các dữ liệu trong
                                                    thùng rác được tự động xóa sau 30 ngày</li>
                                                <li class="font-bold list-disc"
                                                    style="font-family: Arial, Helvetica, sans-serif;">Muốn xóa trực
                                                    tiếp hãy bỏ chọn checkbox bên dưới</li>
                                            </ul>
                                        </div>
                                    </div>
                                </template>
                                <template #footer>
                                    <button
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs"
                                        @click="deleteItems">
                                        Xóa dữ liệu
                                    </button>
                                    <button
                                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs"
                                        @click="isModalDelete = false">
                                        Hủy lệnh
                                    </button>
                                </template>
                            </DialogModal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/Layouts/AppLayout.vue';
import HeaderBreadcrumbs from '@/Components/HeaderBreadcrumbs.vue';
import DialogModal from '@/Components/DialogModal.vue';
import { Link } from '@inertiajs/vue3';
import MultiSelect from 'primevue/multiselect';

const isFormFilter = ref(false);
const items = ref([]);
const headers = [
    { text: "Avatar", value: "image", width: 200 },
    { text: "Name", value: "name", sortable: true },
    { text: "Categories", value: "categories" },
    { text: "Brand", value: "brand" },
    { text: "Status", value: "is_show" },
    { text: "Created At", value: "created_at", sortable: true },
    { text: "Update At", value: "updated_at", sortable: true },
    { text: "Action", value: "operation" },
];

const serverItemsLength = ref(0);
const serverOptions = ref({
    page: 1,
    rowsPerPage: 10,
    sortBy: 'created_at',
    sortType: 'desc',
    name: '',
    categories: [],
    brands: [],
});



const categoriesData = ref([]);
const brandsData = ref([]);
const loadDataCategoriesAndBrands = () => {
    axios.get('/vnwa/ecommerce/products/load-data-categories-and-brands').then(response => {
        categoriesData.value = response.data.categories;
        brandsData.value = response.data.brands;
    }).catch(error => {
        console.error(error)
    })
}
watch([() => serverOptions.value.categories, () => serverOptions.value.brands], () => {
    serverOptions.value.page = 1;
});

const isTableLoading = ref(false);
const isPageLoading = ref(false);
const isModalDelete = ref(false);
const itemsSelected = ref([]);
const itemsDelete = ref([]);
const reRender = ref(1);
const restApiUrl = computed(() => {
    const { page, rowsPerPage, sortBy, sortType, name, categories, brands } = serverOptions.value;
    let url = `/vnwa/ecommerce/products/load-data-table?page=${page}&per_page=${rowsPerPage}&sortBy=${sortBy}&sortType=${sortType}`;
    if (name) {
        url += `&name=${name}`
    }
    if (categories) {
        categories.forEach(element => {
            url += `&categories_id[]=${element.id}`
        });
    }
    if (brands) {
        brands.forEach(element => {
            url += `&brands_id[]=${element.id}`
        });
    }
    return url;
});

const loadFromServer = async () => {
    isTableLoading.value = true;
    reRender.value++;
    try {
        const response = await axios.get(restApiUrl.value);
        items.value = response.data.data;
        serverItemsLength.value = response.data.total;
    } catch (error) {
        console.error(error);
    } finally {
        isTableLoading.value = false;
    }

};
onMounted(() => {
    loadFromServer();
    loadDataCategoriesAndBrands();
})
// Load data initially

// Watch serverOptions to reload data on changes
watch(serverOptions, () => {
    loadFromServer();
}, { deep: true });

const deleteItems = async () => {
    isPageLoading.value = true;
    try {
        const dataDelete = itemsSelected.value.map(item => item.id);
        await axios.post('/vnwa/ecommerce/products/delete', { dataId: dataDelete });
        toast.success('Data deleted successfully');
        isModalDelete.value = false;
        loadFromServer();
    } catch (error) {
        toast.error('Error deleting data');
        console.error(error);
    } finally {
        isPageLoading.value = false;
    }
};

const showisModalDeleteMutipleItem = () => {
    itemsDelete.value = itemsSelected.value.map(item => ({ id: item.id, name: item.name }));
    isModalDelete.value = true;
};

const showIsModalDeleteItem = (deleteId, deleteName) => {
    itemsDelete.value = [{ id: deleteId, name: deleteName }];
    isModalDelete.value = true;
};
</script>

<style>
/* Add any styles you need here */
</style>
