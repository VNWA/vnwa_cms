<template>
    <div>
        <AppLayout title=" Convert Editor" :isLoading="isPageLoading">
            <template #header>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Convert Editor</h2>
                    </div>
                    <div>
                        <HeaderBreadcrumbs :breadcrumbs="[
                            ['Product', route('Ecommerce.Product')],
                            ['Convert  Editor', route('Ecommerce.Product.Convert')]
                        ]" />
                    </div>
                </div>
            </template>

            <div class="p-5">
                <div class="bg-white shadow rounded-sm mb-3 p-5 text-black/80">
                    <div class="mb-4 flex items-center justify-end">
                        <Link :href="route('Ecommerce.Product.Import')"
                            class="bg-sky-600 hover:bg-sky-700 text-white font-bold py-2 px-2 rounded text-nowrap ">
                        <icon :icon="['fas', 'file-import']" /> Import Excel
                        </Link>
                    </div>
                    <div class="mb-4">
                        <InputLabel for="desc" value="Description" />
                        <Editor id="desc" v-model="data" class="mt-1 block w-full" />
                    </div>
                </div>
                <div class=" bg-white shadow rounded-sm mb-3 p-5 text-black/80">
                    <div class="mb-4 float-end">
                        <button @click="copyData"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-3 flex items-center gap-2">
                            <icon :icon="['fas', 'copy']" />
                            Copy String
                        </button>
                    </div>
                    <div>
                        {{ data }}
                    </div>

                </div>
            </div>
        </AppLayout>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeaderBreadcrumbs from '@/Components/HeaderBreadcrumbs.vue';
import { onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Editor from '@/Components/Editor.vue'

const data = ref('');
const copyData = () => {
    navigator.clipboard.writeText(data.value)
        .then(() => {
            alert('Data copied to clipboard!');
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
        });
};
</script>
