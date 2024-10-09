<template>
    <div class=" w-full h-full mb-3">
        <!-- Modal for selecting images -->
        <div v-if="isModal" class="fixed w-full h-full top-0 left-0 bg-black/10 backdrop-blur-sm flex items-center justify-center z-50 p-10">
            <div class="min-w-52 min-h-52 max-h-full max-w-full w-full h-full">
                <div class="flex items-center justify-between px-3 pt-2 bg-white rounded-t-lg">
                    <h3 class="font-bold text-xl">Media Gallery</h3>
                    <button type="button" class="text-3xl font-bold me-5 hover:text-red-500" @click="isModal = false">
                        <icon :icon="['fas', 'x']" />
                    </button>
                </div>
                <MediaPopup @return-data="handleDataFromChild" />
            </div>
        </div>

        <!-- Button to open modal -->
        <div class="flex items-center w-full  mb-3">
            <button @click="isModal = true" style="min-width: 120px;" class="px-5 py-3 w-auto text-sm font-medium text-center text-white bg-blue-700 rounded-lg cursor-pointer hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <icon :icon="['fas', 'circle-down']" /> Chọn ảnh
            </button>
        </div>

        <!-- Image gallery with draggable feature -->
        <div class="border rounded p-4">
            <draggable v-model="images" :item-key="customKeyFunction" tag="ul" class="grid grid-cols-12">
                <template #item="item">
                    <li class="col-span-6 p-1 ButtonMutipleImage_item border">
                        <span class="absolute z-10 bg-white text-black w-5 text-center text-xs bottom-0 border-solid border-purple-700 border-2">{{ item.index }}</span>
                        <img :src="item.element" width="100%" height="auto" class="w-full h-auto" alt="" />
                        <div class="delete">
                            <button @click="deleteItem(item.index)" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <icon :icon="['fas', 'x']" />
                            </button>
                        </div>
                    </li>
                </template>
            </draggable>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import draggable from 'vuedraggable';
import MediaPopup from './MediaPopup.vue';
import { useAttrs, defineEmits } from 'vue';

const props = defineProps({
  modelValue: {
    type: Array,
    default: () => [],
  }
});

const emit = defineEmits(['update:modelValue']);

// State for controlling modal visibility
const isModal = ref(false);

// Initialize images array from props (modelValue)
const images = ref([...props.modelValue]);

// Watch for changes from parent and update images array
watch(() => props.modelValue, (newVal) => {
  images.value = [...newVal];
});

// Function to delete an image
const deleteItem = (index) => {
  images.value.splice(index, 1);
  emit('update:modelValue', images.value);
};

// Function to handle data returned from MediaPopup component
const handleDataFromChild = (data) => {
  if (data.length > 0) {
    data.forEach((file) => {
      images.value.push(file.path);
    });
    isModal.value = false;
    emit('update:modelValue', images.value);
  } else {
    console.warn("Received data is empty.");
  }
};

// Custom key function for draggable component
const customKeyFunction = (item) => {
  return item;
};
</script>

<style>
.ButtonMutipleImage_item {
    width: 100%;
    height: 100%;
    position: relative;
    cursor: move;
}

.ButtonMutipleImage_item:active {
    border: solid 1px rebeccapurple;
}

.ButtonMutipleImage_item .delete {
    position: absolute;
    top: -2px;
    left: -2px;
    display: none;
    z-index: 999;
}

.ButtonMutipleImage_item:hover .delete {
    display: block;
}

.ButtonMutipleImage_item .delete button {
    width: 10px;
    height: 10px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;

}
</style>
