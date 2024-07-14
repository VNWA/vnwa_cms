<template>
    <div class="inline-block" :class="props.class">
        <div v-if="isModal" class="fixed h-full top-0 left-0 bg-black/10 backdrop-blur-sm flex items-center justify-center z-50 p-10">
            <div class="min-w-52 min-h-52 max-h-full max-h-full">
                <div class="flex items-center justify-between px-3 pt-2 bg-white rounded-t-lg">
                    <h3 class="font-bold text-xl">Media Gallery</h3>
                    <button type="button" class="text-3xl font-bold me-5 hover:text-red-500" @click="isModal = false">
                        <icon :icon="['fas', 'x']" />
                    </button>
                </div>
                <MediaPopup @return-data="handleDataFromChild" />
            </div>
        </div>
        <div class="relative border min-w-32 w-auto h-44 border-purple-400 flex items-center justify-center rounded-md rounded-b-none bg-black/5 hover:bg-black/10 cursor-pointer"
            @click="isModal = true">
            <img v-if="url_image" :src="url_image" class="h-44 max-h-44 w-auto" alt="Photo does not exist" />
            <div v-else class="inline-flex items-center justify-center">
                <icon :icon="['fas', 'image']" class="text-4xl text-black/80" />
            </div>
        </div>
        <div class="relative formkit-field">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <icon :icon="['fas', 'image']" />
            </div>
            <input :id="props.id" v-model="url_image"
                @input="emit('update:modelValue', url_image)"
                class="formkit-input bg-gray-50 border border-gray-300 w-full text-gray-900 text-sm rounded-lg focus:ring-stone-500 focus:border-stone-500 block pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-stone-500 dark:focus:border-stone-500 rounded-t-none"
                name="email_address" aria-label="Đường dẫn ảnh" placeholder="Đường dẫn ảnh" required="" type="text" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import MediaPopup from "@/Components/MediaPopup.vue";

const isModal = ref(false);
const props = defineProps({
    modelValue: String,
    id: String,
    class: String
});

const emit = defineEmits(['update:modelValue']);

const url_image = ref(props.modelValue);
watch(() => props.modelValue, (newValue) => {
    url_image.value = newValue;
});

const handleDataFromChild = (data) => {
    if (data.length > 0) {
        const firstItem = data[0];
        url_image.value = firstItem.path;
        isModal.value = false;
        emit('update:modelValue', url_image.value);
    } else {
        console.warn("Received data is empty.");
    }
};

watch(url_image, (newValue) => {
    emit('update:modelValue', newValue);
});
</script>
