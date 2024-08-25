<template>
    <div class="inline-block" :class="props.class">


        <DialogModal :show="isModal" maxWidth="4xl" @close="isModal = false">
            <template #title>
                Media Gallery
            </template>

            <template #content>
                <MediaPopup @return-data="handleDataFromChild" />
            </template>


        </DialogModal>
        <div class="text-gray-500 test-sm ps-3">
            <slot name="desc"></slot>
        </div>
        <div class="relative border min-w-32 w-auto h-44 border-purple-400 flex items-center justify-center rounded-md rounded-b-none bg-black/5 hover:bg-black/10 cursor-pointer"
            @click="isModal = true">
            <img v-if="url_image" :src="url_image" class="h-44 max-h-32 w-auto" alt="Photo does not exist" />
            <div v-else class="inline-flex items-center justify-center">
                <icon :icon="['fas', 'image']" class="text-4xl text-black/80" />
            </div>
        </div>

        <div class="relative formkit-field">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                <icon :icon="['fas', 'image']" />
            </div>
            <input :id="props.id" v-model="url_image" @input="emit('update:modelValue', url_image)"
                class="formkit-input bg-gray-50 border border-gray-300 w-full text-gray-900 text-sm rounded-lg focus:ring-stone-500 focus:border-stone-500 block pl-10 p-2.5 rounded-t-none"
                name="email_address" aria-label="Đường dẫn ảnh" placeholder="Đường dẫn ảnh" required="" type="text" />

        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import MediaPopup from "@/Components/MediaPopup.vue";
import DialogModal from "@/Components/DialogModal.vue";
const isModal = ref(false);
const props = defineProps({
    modelValue: String,
    id: String,
    class: String,
    desc: String,
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
