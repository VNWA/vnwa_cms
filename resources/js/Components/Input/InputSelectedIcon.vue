<template>
    <div class="flex items-center border border-gray-300 rounded-md ">
        <div v-if="input" class="h-full flex items-center justify-center min-w-10 ">
            <icon  :icon="input" />

        </div>
        <VueSelect class="style-chooser  border-none " :class="props.class" taggable v-model="input" :options="options"
            :reduce="(option) => option.value" label="label" placeholder="None">
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
import { fasArray, fabArray } from '@/data/fontawebsome_icon';


const options = ref([])
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

    gap: 10
}
</style>
