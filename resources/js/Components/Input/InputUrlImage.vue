<template>
    <div class="flex items-center w-full h-full mb-3">
        <div v-if="isModal"
            class="fixed w-full h-full top-0 left-0 bg-black/10 backdrop-blur-sm flex items-center justify-center z-50 p-10">
            <div class="min-w-52 min-h-52 max-h-full max-w-full w-full h-full">
                <div class="flex items-center justify-between px-3 pt-2 bg-white rounded-t-lg">
                    <h3 class="font-bold text-xl">Media Galery</h3>
                    <button type="button" class="text-3xl font-bold me-5 hover:text-red-500" @click="isModal = false">
                        <icon :icon="['fas', 'x']" />
                    </button>
                </div>
                <MediaPopup @return-data="handleDataFromChild" />
            </div>
        </div>
        <div class="relative w-full mr-3 formkit-field">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <icon :icon="['fas', 'image']" />
            </div>
            <input :id="props.id" v-model="url_image" @input="notifyParent"
                class="formkit-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                name="email_address" aria-label="Email Address" placeholder="Đường dẫn ảnh" required="" type="email" />
        </div>
        <button @click="isModal = true" style="min-width: 120px"
            class="px-5 py-3 w-auto text-sm font-medium text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            <icon :icon="['fas', 'circle-down']" /> Chọn ảnh
        </button>
    </div>
    <div class="border rounded p-4 flex items-center justify-center">
        <img :src="url_image" class="w-full h-auto max-w-56" alt="" />
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import MediaPopup from "@/Components/MediaPopup.vue";
const isModal = ref(false);
const props = defineProps({
    modelValue: {
        type: String
    },
    id: {
        type: String
    },
    class: {
        type: String
    }

});

const emit = defineEmits()

const url_image = ref(props.modelValue);
watch(url_image, (newValue) => {
    emit('update:modelValue', newValue);
});

const handleDataFromChild = (data) => {
    if (data.length > 0) {
        const firstItem = data[0]; // Lấy phần tử đầu tiên của mảng data
        url_image.value = firstItem.path;
        isModal.value = false;
    } else {
        console.warn("Received data is empty.");
    }
};

</script>
