<template>
    <div>
        <AppLayout title="Edit Profile" :isLoading="isPageLoading">

            <template #header>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Profile</h2>
                    </div>
                    <div>
                        <HeaderBreadcrumbs
                            :breadcrumbs="[['Appearance', route('Appearance')], [' Edit Profile', route('Appearance.Profile')]]" />
                    </div>
                </div>
            </template>

            <div class="p-5">


                <div class="mb-8 bg-white p-5 shadow shadow-black">
                    <InputLabel for="name">Social <span class="text-red-500">*</span></InputLabel>

                    <div class="flex  mb-5">
                        <div class="w-full h-20" id="top-nav">
                            <ul class="px-3 gap-4">
                                <li v-for="(item, index) in data.social" :key="index">
                                    <div class="flex items-center justify-between gap-2">
                                        <button v-if="index > 0" @click="moveItem(index, -1)"
                                            class="hover:text-sky-500/80 text-sky-500/50 font-bold">
                                            <icon :icon="['fas', 'arrow-left']" />
                                        </button>
                                        <div class="border px-2 py-1 rounded bg-white text-black cursor-pointer"
                                            @click="showEdit(index)"
                                            :class="{ 'text-purple-500': form.index === index }">
                                            <icon :icon="item.icon" class="me-1" />
                                            {{ item.name }}
                                        </div>
                                        <button v-if="index < data.social.length - 1" @click="moveItem(index, 1)"
                                            class="hover:text-sky-500/80 text-sky-500/50 font-bold">
                                            <icon :icon="['fas', 'arrow-right']" />
                                        </button>
                                        <button @click="removeItem(index)"
                                            class="text-red-500 hover:text-red-700 font-bold">
                                            <icon :icon="['fas', 'trash']" />
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <button @click="showCreate"
                                class="bg-white border border-purple-500 hover:bg-purple-900 hover:text-white py-2 px-5 rounded-sm text-black text-nowrap ms-3">
                                <icon icon="fa-plus" />
                                Create
                            </button>
                        </div>
                    </div>
                    <div class="mb-4">
                        <InputLabel for="name">Name <span class="text-red-500">*</span></InputLabel>
                        <InputText id="name" :maxLength="150" v-model="form.name" type="text" class="mt-1 block w-full"
                            required />
                    </div>
                    <div class="mb-4">
                        <InputLabel for="InputSelectedIcon">Icon <span class="text-red-500">*</span></InputLabel>
                        <InputSelectedIcon id="InputSelectedIcon"
                            class="mt-1 block w-full border border-solid border-black h-10" v-model="form.icon" />
                    </div>
                    <div class="mb-4">
                        <InputLabel for="link">Link <span class="text-red-500">*</span></InputLabel>
                        <InputDesc id="link" v-model="form.link" class="mt-1 block w-full" />
                    </div>
                    <div class="mt-6 w-full text-center">
                        <button @click="submit"
                            class="bg-purple-500 hover:bg-purple-900 hover:text-white py-2 px-5 rounded-sm text-white text-nowrap ms-3">
                            <icon icon="fa-save" />
                            Save
                        </button>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="bg-white shadow-black shadow border p-3 w-full max-w-full">

                        <InputLabel for="name">Short About <span class="text-red-500">*</span></InputLabel>
                        <Editor v-model="data.short_about" />
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
import { ref, watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import HeaderBreadcrumbs from '@/Components/HeaderBreadcrumbs.vue';
import InputSelectedIcon from '@/Components/Input/InputSelectedIcon.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import InputText from '@/Components/Input/InputText.vue';
import InputDesc from '@/Components/Input/InputDesc.vue';
import Editor from '@/Components/Editor.vue';

const isPageLoading = ref(false);
const form = ref({
    type: 'create',
    index: null,
    name: '',
    icon: [],
    link: '',
});
const shortAbout = ref('');
const data = ref([]);

const loadData = () => {
    isPageLoading.value = true;
    axios.get('/vnwa/appearance/profile/load-json-data')
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
    axios.post('/vnwa/appearance/profile/update', { data: data.value })
        .then(response => {
            toast.success(response.data.message, { autoClose: 1500 });
        })
        .catch(error => {
            toast.error(error.message, { autoClose: 1500 });
        });
};

const showCreate = () => {
    form.value = {
        type: 'create',
        index: null,
        name: '',
        icon: [],
        link: '',
    };
};

const showEdit = (index) => {
    form.value.type = 'edit';
    form.value.index = index;
    form.value.name = data.value.social[index]?.name;
    form.value.icon = data.value.social[index]?.icon;
    form.value.link = data.value.social[index]?.link;
};

const submit = () => {
    if (!form.value.name.trim() || form.value.icon.length !== 2 || !form.value.link.trim()) {
        toast.error('Please enter complete data', { autoClose: 1500 });
        return false;
    }

    const newData = {
        name: form.value.name,
        icon: form.value.icon,
        link: form.value.link,
    };

    if (form.value.index == null) {
        data.value.social.push(newData);
    } else {
        data.value.social[form.value.index] = newData;
    }

    showCreate();
    updateData();
};

const moveItem = (index, direction) => {
    const newIndex = index + direction;
    if (newIndex >= 0 && newIndex < data.value.social.length) {
        const item = data.value.social.splice(index, 1)[0];
        data.value.social.splice(newIndex, 0, item);
        updateData();
    }
};

const removeItem = (index) => {
    data.value.social.splice(index, 1);
    showCreate();
    updateData();
};
</script>
