<template>
    <div class="flex items-center border border-gray-300 rounded-md ">
        <div v-if="input && input.length > 0" class="h-full flex items-center justify-center min-w-10 ">
            <icon :icon="input" />
        </div>
        <VueSelect
            :id="props.id"
            class="style-chooser border-none"
            :class="props.class"
            taggable
            v-model="input"
            :options="options"
            :reduce="(option) => option.value"
            label="label"
            placeholder="None"
        >
            <template v-slot:option="option">
                <div class="flex gap-4">
                    <icon v-if="option.value" :icon="option.value" />
                    {{ option.label }}
                </div>
            </template>
        </VueSelect>
    </div>
</template>

<script setup>
import VueSelect from 'vue-select';
import "vue-select/dist/vue-select.css";
import { ref, defineProps, watch, onMounted } from 'vue';
import { fasArray, fabArray } from '@/Data/fontawebsome_icon';

const options = ref([]);
onMounted(() => {
    options.value = [
        { type: '', name: '', label: 'None', value: null },
        ...fasArray.map(name => ({ label: 'fas ' + name, value: ['fas', name] })),
        ...fabArray.map(name => ({ label: 'fab ' + name, value: ['fab', name] }))
    ];
});

const props = defineProps({
    modelValue: {
        type: Array,
        default: []
    },
    id: String,
    class: {
        type: String,
        default: ''
    },
});

const emit = defineEmits();
const input = ref(props.modelValue);

// Watch to sync `input` with `props.modelValue`
watch(() => props.modelValue, (newValue) => {
    input.value = newValue;
});

// Watch to emit `update:modelValue` when `input` changes
watch(input, (newValue) => {
    emit('update:modelValue', newValue);
});
</script>

<style>
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle {
    border: none;
    box-shadow: none;
    height: 100%;
    gap: 10;
}
</style>
