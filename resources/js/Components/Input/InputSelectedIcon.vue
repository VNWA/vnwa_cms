<template>
        <VueSelect
            class="style-chooser border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm "
            :class="props.class" taggable  v-model="input"
            :options="options"
            :reduce="(option) => option.value" label="label">
            <template v-slot:option="option">
                <div class="flex gap-4">
                    <icon v-if="option.value" :icon="[option.type, option.name]" />
                    {{ option.type }} {{ option.name }}
                </div>
            </template>
        </VueSelect>
</template>

<script setup>
import VueSelect from 'vue-select';
import "vue-select/dist/vue-select.css";
import { ref, defineProps, watch,onMounted } from 'vue';
import { fasArray, fabArray } from '@/data/fontawebsome_icon';


const options = ref([])
onMounted(() => {
     options.value = [
    { type: '', name: '', label: 'None', value: null },
    ...fasArray.map(name => ({ type: 'fas', name, label: 'fas ' + name, value: 'fas ' + name })),
    ...fabArray.map(name => ({ type: 'fab', name, label: 'fab ' + name, value: 'fab ' + name }))
];

});

const props = defineProps({
    modelValue:  {
        type: String,
        default: null
    },
    class: {
        type: String,
        default: ''
    },
});
const emit = defineEmits()

const input = ref(props.modelValue);
watch(input, (newValue) => {
    emit('update:modelValue', newValue);
    console.log(newValue)
});

</script>

<style>
.style-chooser .vs__search::placeholder,
.style-chooser .vs__dropdown-toggle {
    border: none;
    box-shadow: none;
    height: 100%;
}
</style>
