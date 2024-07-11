<template>
    <div>
        <AppLayout title="Categories Blog">
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Categories Blog
                </h2>
            </template>

            <div class="p-5">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-4">
                        <div class="bg-black/80 p-5">
                            <div class=" mb-5 flex items-center justify-between font-bold text-xl bg-white py-2 px-2">
                                <h3 class="text-black ">List</h3>
                                <button @click="formCreate"
                                    class="bg-sky-700 hover:bg-sky-900 py-1 px-5 rounded-sm text-white">
                                    <icon icon="fa-plus" />
                                    Create
                                </button>
                            </div>
                            <Draggable class="mtl-tree" v-model="treeData" treeLine @update:modelValue="onTreeChange">
                                <template #default="{ node, stat }">
                                    <div class=" mx-3 flex cursor-pointer items-center gap-4 "
                                        :class="{ 'font-bold': id_active === node.id }"
                                        @click="changeIdActive(node.id)">{{
                                            node.name }} (1)
                                        <button v-if="id_active === node.id"
                                            class="bg-red-500 hover:bg-red-600 px-2 py-1 text-white rounded-md">
                                            <icon :icon="['fas', 'trash']" />
                                        </button>
                                    </div>
                                    <OpenIcon v-if="stat.children.length" :open="stat.open" class="float-end"
                                        @click.native="stat.open = !stat.open" />
                                </template>
                            </Draggable>
                        </div>
                    </div>
                    <div class="col-span-8 ">
                        <div class=" bg-white relative">
                            <Loading v-if="isLoading" />
                            {{ form }}
                            <div class="p-4">
                                <div class="mb-4">
                                    <InputLabel for="name">Name <span class="text-red-500">*</span></InputLabel>
                                    <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                                        required />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>
                                <div class="mb-4">
                                    <InputLabel for="slug">Slug <span class="text-red-500">*</span></InputLabel>
                                    <TextInput id="slug" v-model="form.slug" type="text" class="mt-1 block w-full"
                                        required />
                                    <InputError class="mt-2" :message="form.errors.slug" />
                                </div>
                                <div class="mb-4 relative">
                                    <InputLabel for="parentId">Parent Id </InputLabel>
                                    <InputTreeSelect id="parentId" :options=treeData v-model="form.parentId"
                                        class="mt-1 block w-full" required />
                                    <InputError class="mt-2" :message="form.errors.slug" />
                                </div>
                                <div class="mb-4">
                                    <InputLabel for="desc" value="Description" />
                                    <InputDesc id="desc" v-model="form.desc" class="mt-1 block w-full" />
                                    <InputError class="mt-2" :message="form.errors.desc" />
                                </div>
                                <div class="mb-4">
                                    <InputLabel for="InputSelectedIcon" value="Icon" />
                                    <InputSelectedIcon id="InputSelectedIcon"
                                        class="mt-1 block w-full border border-solid border-black h-10"
                                        v-model="form.icon" />
                                    <InputError class="mt-2" :message="form.errors.icon" />
                                </div>
                                <div class="mb-4">
                                    <InputLabel for="InputUrlImage" value="Image" />
                                    <InputUrlImage id="InputUrlImage"
                                        class="mt-1 block w-full border border-solid border-black h-10"
                                        v-model="form.image" />
                                    <InputError class="mt-2" :message="form.errors.icon" />
                                </div>
                                <div class="mb-4">
                                    <div
                                        class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
                                        <Checkbox v-model:checked="form.is_show" id="bordered-checkbox-1"
                                            type="checkbox" name="bordered-checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />

                                        <label for="bordered-checkbox-1"
                                            class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Trạng thái: <span v-if="form.is_show"> Phát
                                                hành </span>
                                            <span v-else>
                                                Bản
                                                Nháp
                                            </span>

                                        </label>
                                    </div>
                                    <div
                                        class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">

                                        <Checkbox v-model:checked="form.is_highlight" id="bordered-checkbox-1"
                                            type="checkbox" name="bordered-checkbox"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="bordered-checkbox-2"
                                            class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nổi
                                            bật
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </AppLayout>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { BaseTree, Draggable, pro, OpenIcon } from '@he-tree/vue'
import '@he-tree/vue/style/default.css'
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputSelectedIcon from '@/Components/Input/InputSelectedIcon.vue';
import InputDesc from '@/Components/Input/InputDesc.vue'
import InputUrlImage from '@/Components/Input/InputUrlImage.vue'
import InputTreeSelect from '@/Components/Input/InputTreeSelect.vue'
import Loading from '@/Components/Loading.vue'
const props = defineProps({
    data: Object
})
const treeData = ref(props.data);
const isLoading = ref(false)
const id_active = ref(null);

const changeIdActive = (id) => {
    id_active.value = id;
    console.log(id)
};

const onTreeChange = (newData) => {
    // Cập nhật dữ liệu cây
    treeData.value = newData;

    // Gọi API để cập nhật dữ liệu vào cơ sở dữ liệu
    axios.post('/vnwa/blog/categories/update-tree', { treeData: newData })
        .then(response => {
            toast.success(response.data.message, {
                autoClose: 1500,
            });
        })
        .catch(error => {
            toast.error(error.message, {
                autoClose: 1500,
            });
        });
};

const form = ref({
    parentId: { null: true },
    name: '',
    slug: '',
    icon: [],
    image: '',
    desc: '',
    is_show: true,
    is_highlight: false,
    errors: {
        name: '',
        slug: '',
        image: '',
        icon: '',
        parentId: '',
        desc: '',
        is_show: '',
        is_highlight: '',
    }
})
const formCreate = () => {
    isLoading.value = true
    id_active.value = null
    setTimeout(() => {
        form.value = {
            parentId: {},
            name: '',
            slug: '',
            icon: [],
            image: '',
            desc: '',
            is_show: true,
            is_highlight: false,
            errors: {
                name: '',
                slug: '',
                image: '',
                icon: '',
                parentId: '',
                desc: '',
                is_show: '',
                is_highlight: '',
            }
        }
        isLoading.value = false

    }, 100);

}


// const submit = () => {
//     form.transform(data => ({
//         ...data,
//         remember: form.remember ? 'on' : '',
//     })).post(route('login'), {
//         onFinish: () => form.reset('password'),
//     });
// };

</script>

<style>
.tree-node--with-tree-line {
    position: relative
}

.tree-line {
    position: absolute;
    background-color: #bbb
}

.tree-vline {
    width: 1px;
    top: 0;
    bottom: 0
}

.tree-hline {
    height: 1px;
    top: 50%;
    width: 10px
}

.he-tree--rtl {
    direction: rtl
}

.he-tree-drag-placeholder {
    background: #ddf2f9;
    border: 1px dashed #00d9ff;
    height: 22px;
    width: 100%
}

.he-tree__open-icon {
    cursor: pointer;
    user-select: none;
    display: inline-block
}

.he-tree__open-icon.open {
    transform: rotate(90deg)
}

.he-tree__open-icon svg {
    width: 1em
}

.tree-node-inner {
    cursor: grab;
    background: #dedede;
    border: 1px solid #19293c;
    border-radius: 3px;
    box-sizing: border-box;
    color: inherit;
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 4;
    font-weight: 400;
    height: 40px;
    margin: 5px 0;
    padding: 5px 10px 5px 20px;
    text-decoration: none;
}
</style>
