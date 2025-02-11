<template>
    <div>
        <AppLayout title="Edit Service" :isLoading="isPageLoading">

            <template #header>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Service</h2>
                    </div>
                    <div>
                        <HeaderBreadcrumbs
                            :breadcrumbs="[['Appearance', route('Appearance')], [' Edit Service', route('Appearance.Service')]]" />
                    </div>
                </div>
            </template>

            <div class="p-5">
                <div class="mb-4">
                    <div class="bg-white shadow-black shadow border p-3 w-full max-w-full">
                        <InputLabel for="name"> Service <span class="text-red-500">*</span></InputLabel>
                        <Editor v-model="data.content" />
                        <button @click="updateData"
                            class="bg-purple-500 hover:bg-purple-900 hover:text-white py-2 px-5 rounded-sm text-white text-nowrap ms-3">
                            <icon icon="fa-save" />
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </AppLayout>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import HeaderBreadcrumbs from '@/Components/HeaderBreadcrumbs.vue';
import InputLabel from '@/Components/InputLabel.vue';

import Editor from '@/Components/Editor.vue';

const isPageLoading = ref(false);
const form = ref({
    type: 'create',
    index: null,
    name: '',
    icon: [],
    link: '',
});
const shortService = ref('');
const data = ref([]);

const loadData = () => {
    isPageLoading.value = true;
    axios.get(route('Appearance.Service.LoadData'))
        .then(response => {
            data.value = response.data;
            isPageLoading.value = false;
        })
        .catch(error => {
            console.log(error);
            isPageLoading.value = false;
        });
};

loadData();

const updateData = () => {
    axios.post(route('Appearance.Service.Update'), { data: data.value })
        .then(response => {
            toast.success(response.data.message, { autoClose: 1500 });
        })
        .catch(error => {
            toast.error(error.message, { autoClose: 1500 });
        });
};


</script>
