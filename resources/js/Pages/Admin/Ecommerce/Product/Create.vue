<template>
    <div>
        <AppLayout title=" Create New Product" :isLoading="isPageLoading">
            <template #header>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Product</h2>
                    </div>
                    <div>
                        <HeaderBreadcrumbs
                            :breadcrumbs="[['Product', route('Ecommerce.Product')], [' Create', route('Ecommerce.Product.Create')]]" />
                    </div>
                </div>
            </template>

            <div class="grid grid-cols-12 gap-4 p-2">
                <div class="lg:col-span-8 col-span-12">
                    <div class="bg-white shadow rounded-sm mb-3 p-2">
                        <div class="mb-4">
                            <InputLabel for="name">Name <span class="text-red-500">*</span></InputLabel>
                            <InputText id="name" :maxLength="150" v-model="form.name" type="text"
                                class="mt-1 block w-full" @change="nameChange" required />
                            <InputError class="mt-2" :message="errors.name" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="slug">Slug <span class="text-red-500">*</span></InputLabel>
                            <div>
                                <div class="relative">

                                    <div class="flex items-center justify-start">
                                        <div
                                            class=" block border-r-0 rounded-r-none border h-full py-2 px-2 bg-gray-50 text-nowrap text-black ">
                                            {{ url_web.origin }} /
                                        </div>
                                        <TextInput id="slug" v-model="form.slug" type="text"
                                            class=" block w-full pe-14 rounded-l-none"
                                            :class="{ 'border-red-500 focus:ring-red-500': errors.slug.trim().length > 0 }"
                                            required @change="checkSlug($event.target.value)" />
                                    </div>
                                    <div class="absolute top-2 right-5">
                                        <div role="status" v-if="isSlugLoading">
                                            <svg aria-hidden="true"
                                                class="w-6 h-6 text-gray-200 animate-spin  fill-purple-600"
                                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                    fill="currentFill" />
                                            </svg>
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <icon
                                            v-if="!isSlugLoading && form.slug.trim().length > 0 && errors.name.trim().length <= 0 && errors.slug.trim().length > 0"
                                            class="text-red-500 font-bold text-lg" :icon="['fas', 'x']" />
                                        <icon
                                            v-else-if="!isSlugLoading && form.slug.trim().length > 0 && errors.name.trim().length <= 0 && errors.slug.trim().length <= 0"
                                            class="text-green-500 font-bold text-lg" :icon="['fas', 'check']" />
                                    </div>
                                </div>

                            </div>
                            <InputError class="mt-2" :message="errors.slug" />
                        </div>
                        <div class="bg-white shadow rounded-sm mb-3 p-2">
                            <div class="py-2 border-b border-black/10 mb-5">
                                <InputLabel>Images <span class="text-red-500">*</span></InputLabel>

                            </div>
                            <div>
                                <ButtonMutipleImage v-model="form.images" />
                                <InputError class="mt-2" :message="errors.images" />

                            </div>
                        </div>

                        <div class="mb-4">
                            <InputLabel for="desc" value="Description" />
                            <Editor id="desc" v-model="form.description" class="mt-1 block w-full" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="tech_info" value="Tech Info" />
                            <Editor id="tech_info" v-model="form.tech_info" class="mt-1 block w-full" />
                        </div>
                    </div>
                    <div class="bg-white shadow rounded-sm mb-3 p-2">

                        <div>
                            <SeoMetaForm v-model="form.seo_meta" />
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-4 col-span-12">
                    <div class="flex flex-col">

                        <div class="bg-white shadow rounded-sm mb-3 p-2 sticky top-0">
                            <div class="py-2 border-b border-black/10 mb-5">
                                <h2 class="text-lg font-bold">Publish</h2>
                            </div>

                            <div class="flex items-center justify-end gap-4  ">
                                <button @click="submit(false)"
                                    class="flex-items-center justify-center bg-white hover:bg-white/80 rounded-md px-5 py-2 min-w-24 text-black/80 border text-lg font-bold">
                                    <icon :icon="['fas', 'floppy-disk']" /> Save & Exit
                                </button>
                                <button @click="submit"
                                    class="flex-items-center justify-center bg-purple-500 hover:bg-purple-500/80 rounded-md px-5 py-2 min-w-24 text-white text-lg font-bold">
                                    <icon :icon="['fas', 'floppy-disk']" /> Save
                                </button>

                            </div>
                            <div class="mb-4">
                                <InputLabel for="sku">SKU <span class="text-red-500">*</span></InputLabel>
                                <input id="sku" v-model="form.sku" type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required />
                                <InputError class="mt-2" :message="errors.sku" />
                            </div>
                            <div class="mb-4">
                                <InputLabel for="origin">Origin <span class="text-red-500">*</span></InputLabel>
                                <input id="origin" v-model="form.origin" type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required />
                                <InputError class="mt-2" :message="errors.origin" />
                            </div>
                            <div class="mb-4">
                                <InputLabel for="stock">Stock <span class="text-red-500">*</span></InputLabel>
                                <input id="stock" v-model="form.stock" type="number"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required />
                                <InputError class="mt-2" :message="errors.stock" />
                            </div>
                        </div>
                        <div class="bg-white shadow rounded-sm mb-3 p-2 text-black">

                            <div class="mb-4">
                                <InputLabel for="Brand">Brand <span class="text-red-500">*</span></InputLabel>
                                <select name="brand" id="Brand" v-model="form.brand_id">
                                    <option v-for="(item, index) in brandsData" :key="index" :value="item.id">{{
                                        item.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="errors.brand_id" />
                            </div>
                        </div>
                        <div class="bg-white shadow rounded-sm mb-3 p-2">
                            <div class="py-2 border-b border-black/10 mb-5">
                                <h2 class="text-md flex items-center gap-2">Status <span
                                        class="text-red-500 font-bold">*</span>
                                </h2>
                            </div>
                            <div class="flex items-center ps-4">
                                <Checkbox v-model:checked="form.is_show" id="bordered-checkbox-1" type="checkbox"
                                    name="bordered-checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500   focus:ring-2  " />

                                <label for="bordered-checkbox-1"
                                    class="w-full py-2 ms-2 text-sm font-medium text-gray-900  cursor-pointer">
                                    Status: <span v-if="form.is_show"> Published </span>
                                    <span v-else>
                                        Draft
                                    </span>

                                </label>
                            </div>
                        </div>

                        <div class="bg-white shadow rounded-sm mb-3 p-2">
                            <div class="py-2 border-b border-black/10 mb-5">
                                <h2 class="text-md flex items-center gap-2">Category</h2>
                            </div>
                            <div>
                                <CheckBoxTree v-model="form.parentIds" :data="categoriesData" />
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            {{ route }}
        </AppLayout>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeaderBreadcrumbs from '@/Components/HeaderBreadcrumbs.vue';
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputText from '@/Components/Input/InputText.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import SeoMetaForm from '@/Components/SeoMetaForm.vue'
import Editor from '@/Components/Editor.vue'
import CheckBoxTree from '@/Components/CheckBoxTree.vue'
import { convertToSlug } from '@/utils';
import ButtonMutipleImage from '@/Components/ButtonMutipleImage.vue';
const url_web = new URL(window.location.href)

const isPageLoading = ref(false);
const form = ref({
    parentIds: [],
    is_show: true,
    brand_id: '',
    sku: '',
    stock: 100000,
    origin: '',
    images: [],
    name: '',
    slug: '',
    catalogs: [],
    description: '',
    tech_info: '',
    seo_meta: {
        meta_title: "",
        meta_desc: "",
        meta_image: "",
    }
});
const errors = ref({
    name: '',
    slug: '',
    images: '',
    brand_id: '',
    sku: '',
    stock: '',
    origin: '',

})
const isSlugLoading = ref(false);
const categoriesData = ref([]);
const brandsData = ref([]);
const loadDataCategoriesAndBrands = () => {
    axios.get('/vnwa/ecommerce/products/load-data-categories-tree-and-brands').then(response => {
        categoriesData.value = response.data.categories;
        brandsData.value = response.data.brands;
    }).catch(error => {
        console.error(error)
    })
}

onMounted(() => {
    loadDataCategoriesAndBrands();
})
const clearError = () => {
    errors.value = {
        name: '',
        slug: '',
        images: '',
        brand_id: '',
        sku: '',
        stock: '',
        origin: '',
    }
}

const checkSlug = (slug) => {
    clearError();
    if (slug) {
        const model_type = 'App\Models\Product';
        isSlugLoading.value = true;
        const url = ref('');
        if (form.value.id) {
            url.value = '/vnwa/check-slug/' + slug + '/' + model_type + '/' + form.value.id;
        } else {
            url.value = '/vnwa/check-slug/' + slug;
        }
        // Gửi request kiểm tra slug
        axios.get(url.value)
            .then(response => {
                // Xử lý kết quả trả về từ server
                if (response.data.type === 'error') {
                    // Xử lý khi slug đã tồn tại
                    errors.value.slug = response.data.message;

                    // Hiển thị thông báo hoặc xử lý người dùng
                } else {
                    // Nếu slug hợp lệ, có thể thực hiện các bước tiếp theo
                    // Ví dụ: cập nhật meta_title

                }
            })
            .catch(error => {
                errors.value.slug = error.response.data.message;
            });
        isSlugLoading.value = false;
    }

}

const nameChange = (value) => {
    form.value.slug = convertToSlug(value);
    checkSlug(form.value.slug);
}

const submit = (isRollBack = true) => {
    clearError();
    isPageLoading.value = true;
    axios.post('/vnwa/ecommerce/products/create', form.value).then(response => {
        toast.success(response.data.message);
        isPageLoading.value = false;
        if (!isRollBack) {
            window.history.back();
        } else {
            form.value.name = ''
            form.value.slug = ''
        }
    }).catch(error => {
        isPageLoading.value = false;

        if (error.response.data.errors) {
            const errorKeys = Object.keys(error.response.data.errors);
            errorKeys.forEach(key => {
                if (key in errors.value) {
                    errors.value[key] = error.response.data.errors[key][0]; // Lấy giá trị lỗi đầu tiên (nếu có)
                }
            });
        }

        toast.error(error.message, {
            autoClose: 1500,
        });
    })

}

</script>

<style></style>
